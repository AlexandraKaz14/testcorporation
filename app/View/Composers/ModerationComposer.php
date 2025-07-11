<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Moderation;
use App\Models\User;
use Illuminate\View\View;

class ModerationComposer
{
    public function compose(View $view)
    {
        $statuses = Moderation::MODERATION_STATUSES;
        $moderators = User::where('role', User::ROLE_ADMIN)
            ->orderBy('name')
            ->get();

        $authors = User::join('tests', 'users.id', '=', 'tests.user_id')
            ->join('moderation_tests', 'tests.id', '=', 'moderation_tests.test_id')
            ->select('users.*')
            ->distinct()
            ->get();

        $view->with([
            'statuses' => $statuses,
            'moderators' => $moderators,
            'authors' => $authors,
        ]);
    }
}
