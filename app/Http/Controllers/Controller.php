<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;

    protected function getCart()
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
