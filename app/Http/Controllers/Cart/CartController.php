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
        $cart = Cart::where('session_id', session()->id())->first();

        $this->authorize('view', [Cart::class, $cart]);

        return Inertia::render('Cart/Show', [
            'cart' => $cart?->load('items'),
        ]);
    }
}
