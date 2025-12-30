<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperFile
 */
class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'original_name',
        'path',
        'disk',
        'size',
    ];

    protected $appends = [
        'url',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    /**
     * Determine if the user is an administrator.
     */
    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::disk($this->disk)->url($this->path),
        );
    }
}
