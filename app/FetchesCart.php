<?php

namespace App;

use App\Models\Cart;

trait FetchesCart
{
    protected function getCart(): Cart
    {
        $sessionId = session()->id();

        $cart = Cart::where('session_id', $sessionId)->first();

        if ($cart) {
            return $cart;
        }

        // Create a new anonymous cart
        return Cart::create([
            'session_id' => $sessionId,
        ]);
    }
}
