<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Society;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $society = Society::first();

        $cart = $this->getCart();

        $this->authorize('view', [Cart::class, $cart]);

        return Inertia::render('cart/Show', [
            'cart' => $cart->load(['items.product.images']),
            'society' => $society,
        ]);
    }
}
