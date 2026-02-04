<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HasEnoughStock implements ValidationRule
{
    public function __construct(
        protected int $productId,
        protected int $existingQuantity = 0
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $product = Product::find($this->productId);

        $requestedQuantity = (int) $value + $this->existingQuantity;

        if ($requestedQuantity > $product->stock) {
            $fail('Not enough stock for the requested quantity.');
        }
    }
}
