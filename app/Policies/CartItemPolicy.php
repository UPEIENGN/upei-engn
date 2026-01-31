<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;

class CartItemPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user, Cart $cart): bool
    {
        return $cart->session_id === session()->id();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?User $user, Cart $cart, CartItem $cartItem): bool
    {
        return $cart->id === $cartItem->cart_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?User $user, Cart $cart, CartItem $cartItem): bool
    {
        return $cart->id === $cartItem->cart_id;

    }
}
