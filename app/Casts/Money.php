<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

class Money implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): int|float
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException('The given value is not an numeric value.');
        }

        return $value / 100;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException('The given value is not an numeric value.');
        }

        return (int) round($value * 100);

    }
}
