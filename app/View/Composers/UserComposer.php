<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\User;
use Illuminate\View\View;

class UserComposer
{
    public function compose(View $view)
    {
        $roles = User::ROLES;
        $statuses = User::STATUSES;

        $view->with([
            'roles' => $roles,
            'statuses' => $statuses,
        ]);
    }
}
