<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', [Product::class, $this->society, $this->product]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],

            'colors' => ['nullable', 'array'],
            'colors.*' => ['string'],

            'sizes' => ['nullable', 'array'],
            'sizes.*' => ['string'],

            'promo_codes' => ['nullable', 'array'],
            'promo_codes.*.code' => ['string'],
            'promo_codes.*.type' => ['string', 'in:amount,percentage'],
            'promo_codes.*.value' => ['integer', 'min:0'],

            'images' => ['sometimes', 'array'],
            'images.*' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:10240'],
        ];
    }
}
