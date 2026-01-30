<?php

namespace App\Models;

use App\SocietyMemberRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperSocietyMember
 */
class SocietyMember extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'role',
        'title',
        'description',
        'executive_display_order',
        'renewed_at',
    ];

    protected $casts = [
        'renewed_at' => 'date',
    ];

    protected $appends = [
        'is_expired',
        'role_label',
    ];

    protected function isExpired(): Attribute
    {
        return new Attribute(
            get: function () {
                if (! $this->renewed_at) {
                    return true;
                }

                $now = Carbon::now();
                $renewedDate = Carbon::parse($this->renewed_at);

                $currentYearStart = $now->month < 9 || ($now->month == 9 && $now->day < 6)
                    ? Carbon::create($now->year - 1, 9, 6)
                    : Carbon::create($now->year, 9, 6);

                return $renewedDate->lessThan($currentYearStart);
            },
        );
    }

    protected function roleLabel(): Attribute
    {
        return new Attribute(
            get: function () {
                /** @var SocietyMemberRole $role */
                $role = $this->role;

                return $role->label();
            },
        );
    }

    protected function casts(): array
    {
        return [
            'role' => SocietyMemberRole::class,
        ];
    }

    public function image(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
