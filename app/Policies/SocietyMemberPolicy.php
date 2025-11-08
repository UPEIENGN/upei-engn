<?php

namespace App\Policies;

use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\User;
use App\SocietyMemberRole;

class SocietyMemberPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Society $society): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Society $society): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Society $society, SocietyMember $societyMember): bool
    {
        if ($societyMember->role == SocietyMemberRole::Owner) {
            return $society->userHasRole($user, [
                SocietyMemberRole::Owner,
            ]);
        }

        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function reorderExecutives(User $user, Society $society): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Society $society, SocietyMember $societyMember): bool
    {
        if ($user->email == $societyMember->email) {
            return false;
        }

        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }
}
