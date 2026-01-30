<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        $cart = $this->getCart();

        $this->authorize('view', [Cart::class, $cart]);

        return Inertia::render('society/cart/Show', [
            'cart' => $cart?->load('items'),
        ]);
    }
}
