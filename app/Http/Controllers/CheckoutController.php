<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Society;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Cashier\Cashier;

class CheckoutController extends Controller
{
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId === null) {
            return redirect()->route('home');
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect()->route('cart.show')->with('error', 'Payment was not successful.');
        }

        $cartId = $session->metadata['cart_id'] ?? null;

        $society = Society::first();

        $cart = Cart::find($cartId);

        $order = $society->orders()->create([
            'name' => $session->customer_details['name'],
            'email' => $session->customer_details['email'],
            'phone' => $session->customer_details['phone'],
            'payment_intent' => $session->payment_intent,
        ]);

        $order->items()->createMany($cart->items->map(function (CartItem $cartItem) {
            $cartItem->product->decrement('stock', $cartItem->quantity);

            return [
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'color' => $cartItem->color,
                'size' => $cartItem->size,
            ];
        }));

        $cart->items()->delete();

        return Inertia::render('store/checkout/Success', [
            'order' => $order,
        ]);
    }

    public function cancel()
    {
        return redirect()
            ->route('cart.show')
            ->with('error', 'Payment was cancelled.');
    }
}
