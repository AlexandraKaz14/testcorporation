<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Test;
use App\Models\User;

class TestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyOrCreate(User $user): bool
    {
        return $user->id || $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewOrUpdateOrDelete(User $user, Test $test): bool
    {
        if (!$user->isAdmin() && $test->status !== Test::STATUS_DRAFT) {
            return false;
        }
        return $user->id === $test->user_id || $user->isAdmin();
    }

    public function submitForModeration(User $user, Test $test): bool
    {
        return $user->id === $test->user_id || $user->isAdmin();
    }

    public function submitForPublication(User $user, Test $test): bool
    {
        return $user->isAdmin();
    }
}
