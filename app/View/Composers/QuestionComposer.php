<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\Question;
use Illuminate\View\View;

class QuestionComposer
{
    public function compose(View $view)
    {
        $types = Question::TYPES_ANSWERS;

        $view->with([
            'types' => $types,
        ]);
    }
}
