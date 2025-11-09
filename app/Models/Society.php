<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSociety
 */
class Society extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'email',
        'facebook_url',
        'instagram_handle',
        'twitter_handle',
        'discord_url',
        'meeting_schedule',
        'meeting_location',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(SocietyMember::class);
    }

    public function executives(): HasMany
    {
        return $this->hasMany(SocietyMember::class)
            ->whereNotNull('executive_display_order')
            ->orderBy('executive_display_order');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function userHasRole(User $user, $roles): bool
    {
        $roles = is_array($roles) ? $roles : [$roles];

        return $this->members()
            ->where('email', $user->email)
            ->whereIn('role', $roles)
            ->exists();
    }
}
