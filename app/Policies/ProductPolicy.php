<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Society;
use App\Models\User;
use App\SocietyMemberRole;

class ProductPolicy
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
    public function update(User $user, Society $society, Product $product): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Society $society, Product $product): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }
}
