<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Reaction;
use Illuminate\View\View;

class ReactionComposer
{
    public function compose(View $view)
    {
        $operations = Reaction::OPERATIONS;

        $view->with([
            'operations' => $operations,
        ]);
    }
}
