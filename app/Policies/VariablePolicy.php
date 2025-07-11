<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use App\Models\Variable;

class VariablePolicy
{
    /**
     * Determine whether the user can view, create, update the model.
     */
    public function viewOrCreateOrUpdate(User $user, Variable $variable): bool
    {
        if (!$variable->test) {
            return false;
        }

        if (!$user->isAdmin() && $variable->test->status !== Test::STATUS_DRAFT) {
            return false;
        }

        return $user->id === $variable->test->user_id || $user->isAdmin();
    }

    public function view(User $user, Variable $variable): bool
    {
        if (!$variable->test) {
            return false;
        }

        return $user->id === $variable->test->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete or restore the model.
     */
    public function deleteOrRestore(User $user, Variable $variable): bool
    {
        if ($variable->test->status !== Test::STATUS_DRAFT) {
            return false;
        }
        return $user->id === $variable?->test?->user_id || $user->isAdmin();
    }
}
