<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Answer;
use App\Models\Test;
use App\Models\User;

class AnswerPolicy
{
    /**
     * Determine whether the user can view, create, update the model.
     */
    public function viewOrCreateOrUpdate(User $user, Answer $answer): bool
    {
        if (!$answer->question) {
            return false;
        }

        if (!$user->isAdmin() && $answer->question->test->status !== Test::STATUS_DRAFT) {
            return false;
        }

        return $user->id === $answer?->question?->test?->user_id || $user->isAdmin();

    }

    public function viewOrCreate(User $user, Answer $answer): bool
    {
        if (!$answer->question) {
            return false;
        }

        return $user->id === $answer->question->test->user_id || $user->isAdmin();

    }

    /**
     * Determine whether the user can delete and restore the model.
     */
    public function deleteOrRestore(User $user, Answer $answer): bool
    {
        if (!$user->isAdmin() && $answer->question->test->status !== Test::STATUS_DRAFT) {
            return false;
        }
        return $user->id === $answer?->question?->test?->user_id || $user->isAdmin();
    }
}
