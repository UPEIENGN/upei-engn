<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Society;
use App\Models\User;
use App\SocietyMemberRole;

class OrderPolicy
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
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user, Cart $cart): bool
    {
        return $cart->session_id == session()->id();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Society $society, Order $order): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }

    public function export(User $user, Society $society): bool
    {
        return $society->userHasRole($user, [
            SocietyMemberRole::Admin,
            SocietyMemberRole::Owner,
        ]);
    }
}
