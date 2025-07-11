<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Result;
use App\Models\Test;
use App\Models\User;
use App\Models\Variable;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\ReactionPolicy;
use App\Policies\ResultPolicy;
use App\Policies\TestPolicy;
use App\Policies\VariablePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Test::class => TestPolicy::class,
        Question::class => QuestionPolicy::class,
        Answer::class => AnswerPolicy::class,
        Variable::class => VariablePolicy::class,
        Result::class => ResultPolicy::class,
        ReactionPolicy::class => Reaction::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('search-user', function (User $user) {
            return $user->isAdmin();
        });
    }
}
