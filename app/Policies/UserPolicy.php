<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * @param User $currentUser
     * @param User $userToDestroy
     * @return bool
     */
    public function destroy(User $currentUser, User $userToDestroy): bool
    {
        return $currentUser->is_admin && $currentUser->id !== $userToDestroy->id;
    }
}
