<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Result;
use App\Models\Test;
use App\Models\User;

class ResultPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function viewOrCreateOrUpdate(User $user, Result $result): bool
    {
        if (!$result->test) {
            return false;
        }
        if (!$user->isAdmin() && $result->test->status !== Test::STATUS_DRAFT) {
            return false;
        }

        return $user->id === $result->test->user_id || $user->isAdmin();
    }

    public function view(User $user, Result $result): bool
    {
        if (!$result->test) {
            return false;
        }
        return $user->id === $result->test->user_id || $user->isAdmin();

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Result $result): bool
    {
        if ($result->test->status !== Test::STATUS_DRAFT) {
            return false;
        }
        return $user->id === $result?->test?->user_id || $user->isAdmin();
    }
}
