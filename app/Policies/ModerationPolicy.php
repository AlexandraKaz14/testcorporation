<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Moderation;
use App\Models\User;

class ModerationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Moderation $moderation): bool
    {
        return $moderation->moderation_status === Moderation::MODERATION_STATUS_PENDING;
    }
}
