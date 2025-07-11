<?php

declare(strict_types=1);

namespace App\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CurrentUserComposer
{
    public function compose(View $view)
    {
        $currentUser = Auth::user();

        $view->with([
            'currentUser' => $currentUser,
            'currentUserRole' => $currentUser?->role,
        ]);
    }
}
