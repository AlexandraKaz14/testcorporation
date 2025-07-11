<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Reaction;
use App\Models\Test;
use App\Models\User;

class ReactionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reaction $reaction): bool
    {
        if (!$reaction->answer->question->test) {
            return false;
        }
        return $user->id === $reaction->answer->question->test->user_id || $user->isAdmin();
    }

    public function viewOrCreateOrUpdate(User $user, Reaction $reaction): bool
    {
        if (!$reaction->answer->question->test) {
            return false;
        }

        if (!$user->isAdmin() && $reaction->answer->question->test->status !== Test::STATUS_DRAFT) {
            return false;
        }
        return $user->id === $reaction->answer->question->test->user_id || $user->isAdmin();

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reaction $reaction): bool
    {
        if ($reaction->answer->question->test->status !== Test::STATUS_DRAFT) {
            return false;
        }
        return $user->id === $reaction?->answer?->question?->test?->user_id || $user->isAdmin();
    }
}
