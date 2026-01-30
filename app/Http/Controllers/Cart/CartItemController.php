<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItem\StoreCartItemRequest;
use App\Http\Requests\CartItem\UpdateCartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;

class CartItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request)
    {
        $cart = $this->getCart();

        $this->authorize('create', [CartItem::class, $cart]);

        $item = $cart->items()->create([...$request->validated()]);

        return back()->with('success', 'Item added to cart.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cart = $this->getCart();

        $this->authorize('update', [CartItem::class, $cart, $cartItem]);

        $cartItem->update($request->validated());

        return back()->with('success', 'Cart item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $cart = $this->getCart();

        $this->authorize('delete', [CartItem::class, $cart, $cartItem]);

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
