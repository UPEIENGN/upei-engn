<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart_id' => ['required', 'uuid', 'exists:carts,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
        ];
    }
}
