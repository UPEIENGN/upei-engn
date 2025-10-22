<?php

namespace App\Models;

use App\Casts\Money;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => Money::class,
        ];
    }

    public function society()
    {
        return $this->belongsTo(Society::class);
    }
}
