<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'society_id',
        'title',
        'description',
        'location',
        'start',
        'end',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }

    public function society()
    {
        return $this->belongsTo(Society::class);
    }
}
