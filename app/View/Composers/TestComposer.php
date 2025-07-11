<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Theme;
use App\Models\User;
use Illuminate\View\View;

class TestComposer
{
    public function compose(View $view)
    {
        $categories = Category::query()->orderBy('title')->get();
        $tags = Tag::query()->orderBy('name')->get();
        $users = User::query()->orderBy('name')->get();
        $statuses = Test::STATUSES;
        $deletedStatuses = Test::DELETED_STATUSES;
        $themes = Theme::query()->orderBy('id')->get();
        $view->with([
            'categories' => $categories,
            'tags' => $tags,
            'users' => $users,
            'statuses' => $statuses,
            'deletedStatuses' => $deletedStatuses,
            'themes' => $themes,
        ]);
    }
}
