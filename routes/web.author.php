<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReactionController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\VariableController;
use App\Http\Middleware\IsAuthorMiddleware;
use App\Http\Middleware\LimiterOperations;
use Illuminate\Support\Facades\Route;

Route::prefix('author')->name('author.')->middleware(['auth', 'verified', IsAuthorMiddleware::class, LimiterOperations::class, 'throttle:100,1', 'throttle:3600,60'])->group(function () {
    Route::prefix('tests')->name('tests.')->group(function () {
        Route::resource('questions', QuestionController::class);
        Route::post('questions/{question}/restore', [QuestionController::class, 'restore'])
            ->name('questions.restore');

        Route::post('/questions/{question}/answer-sequence', [AnswerController::class, 'updateAnswerSequence'])
            ->name('questions.answer_sequence');

        Route::prefix('questions')->name('questions.')->group(function () {
            Route::resource('answers', AnswerController::class);
            Route::post('/answers/{answer}/restore', [AnswerController::class, 'restore'])
                ->name('answers.restore');

            Route::prefix('answers')->name('answers.')->group(function () {
                Route::resource('reactions', ReactionController::class);
            });
        });
        Route::resource('variables', VariableController::class);
        Route::post('/variables/{variable}/restore', [VariableController::class, 'restore'])
            ->name('variables.restore');
        Route::resource('results', ResultController::class);
    });

    Route::resource('tests', TestController::class);
    Route::post('/tests/{test}/restore', [TestController::class, 'restore'])
        ->name('tests.restore');
    Route::post('/tests/{test}/question-sequence', [QuestionController::class, 'updateQuestionSequence'])->name('tests.question_sequence');
    Route::post('/tests/{test}/result-sequence', [ResultController::class, 'updateResultSequence'])->name('tests.result_sequence');
    Route::get('/tests/{test}/publish', [TestController::class, 'publish'])->name('tests.publish');
    Route::get('/tests/{test}/return-draft', [TestController::class, 'returnTestToDraft'])->name('tests.return_draft');
    Route::get('/tests/{test}/moderation', [TestController::class, 'submitForModeration'])->name('tests.submit_moderation');
});
