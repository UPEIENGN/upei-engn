<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Society;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Checkout;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Society $society)
    {
        $this->authorize('viewAny', [Order::class, $society]);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'created_at');
        $desc = $request->boolean('desc', true);

        $orders = $society->orders()
            ->where('name', 'like', "%$search%")
            ->orderBy($sort, $desc ? 'desc' : 'asc')
            ->paginate($perPage);

        return Inertia::render('admin/order/Index', [
            'society' => $society,
            'orders' => $orders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'promo_codes' => ['nullable', 'array'],
            'promo_codes.*' => ['string'],
        ]);

        $cart = $this->getCart();

        $this->authorize('create', [Order::class, $cart]);

        if ($cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $requestPromoCodes = collect($request->input('promo_codes', []));

        $lineItems = $cart->items->map(function (CartItem $cartItem) use ($requestPromoCodes) {
            $unitAmount = $cartItem->product->price * 100; // Convert to cents

            // Collect all promo codes from the product that match codes sent by the user
            $applicableProductPromoCodes = collect();
            if (! empty($cartItem->product->promo_codes) && $requestPromoCodes->isNotEmpty()) {
                foreach ($cartItem->product->promo_codes as $productPromo) {
                    // Check if the product's promo code is among the codes sent by the user
                    if (isset($productPromo['code']) && $requestPromoCodes->contains($productPromo['code'])) {
                        $applicableProductPromoCodes->push($productPromo);
                    }
                }
            }

            // Apply all applicable promo codes sequentially
            foreach ($applicableProductPromoCodes as $appliedPromoCode) {
                if ($appliedPromoCode['type'] === 'percentage') {
                    $unitAmount -= $unitAmount * ($appliedPromoCode['value'] / 100);
                } elseif ($appliedPromoCode['type'] === 'amount') {
                    $unitAmount -= $appliedPromoCode['value'] * 100; // Convert to cents
                }
                $unitAmount = max(0, $unitAmount); // Ensure unitAmount doesn't go below zero
            }

            return [
                'price_data' => [
                    'currency' => 'cad',
                    'unit_amount' => round($unitAmount), // Stripe expects integer in cents
                    'product_data' => [
                        'name' => "{$cartItem->product->name}, {$cartItem->color}, {$cartItem->size}",
                    ],
                ],
                'quantity' => $cartItem->quantity,
            ];
        })->all();

        return Inertia::location(Checkout::guest()->create($lineItems, [
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
            'metadata' => [
                'cart_id' => $cart->id,
            ],
            'phone_number_collection' => ['enabled' => true],
            'name_collection' => [
                'individual' => ['enabled' => true],
            ],
        ])->url);
    }

    /**
     * Display the specified resource.
     */
    public function show(Society $society, Order $order)
    {
        $this->authorize('view', [Order::class, $society, $order]);

        return Inertia::render('admin/order/Show', [
            'society' => $society,
            'order' => $order->load(['items', 'items.product']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Society $society, Order $order)
    {
        $this->authorize('delete', [Order::class, $society, $order]);

        $stripe = Cashier::stripe();

        $refund = $stripe->refunds->create([
            'payment_intent' => $order->payment_intent,
        ]);

        $order->items()->each(function (OrderItem $orderItem) {
            $orderItem->product->increment('stock', $orderItem->quantity);
        });

        $order->items()->delete();
        $order->delete();

        return back()->with('success', 'Order refunded and deleted successfully.');
    }

    public function export(Society $society)
    {
        $this->authorize('export', [Order::class, $society]);

        return new OrdersExport;
    }
}
