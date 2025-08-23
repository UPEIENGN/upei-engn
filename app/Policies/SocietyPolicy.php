<?php

namespace App\Policies;

use App\Models\Society;
use App\Models\User;
use App\SocietyMemberRole;
use Illuminate\Auth\Access\Response;

class SocietyPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Society $society): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Society $society): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }
}
