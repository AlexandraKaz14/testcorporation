<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Test;
use Illuminate\View\View;

class GroupComposer
{
    public function compose(View $view)
    {
        $tests = Test::query()
            ->where('status', 'active')
            ->orderBy('title')
            ->get();

        $view->with([
            'tests' => $tests,
        ]);
    }
}
