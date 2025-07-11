<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Question;
use App\Models\Test;
use App\Models\User;

class QuestionPolicy
{
    /**
     * Determine whether the user can, create, update  view the model.
     */
    public function storeOrUpdateOrDelete(User $user, Question $question): bool
    {
        if (!$question->test) {
            return false;
        }

        if (!$user->isAdmin() && $question->test->status !== Test::STATUS_DRAFT) {
            return false;
        }

        return $user->id === $question?->test?->user_id || $user->isAdmin();
    }

    public function viewOrCreate(User $user, Question $question): bool
    {
        if (!$question->test) {
            return false;
        }

        return $user->id === $question->test->user_id || $user->isAdmin();
    }
}
