<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\AuditController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ReactionController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariableController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', IsAdminMiddleware::class])->group(function () {
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::get('/users/login-as-user/{user}', [UserController::class, 'loginAsUser'])->name('users.login_as_user');
    Route::resource('categories', CategoryController::class);
    Route::resource('themes', ThemeController::class);
    Route::resource('groups', GroupController::class);

    Route::resource('moderations', ModerationController::class);
    Route::post('moderations/{moderation}/approved', [ModerationController::class, 'approved'])->name('moderations.approved');
    Route::post('moderations/{moderation}/rejected', [ModerationController::class, 'rejected'])->name('moderations.rejected');

    Route::post('/groups/{group}/restore', [GroupController::class, 'restore'])->name('groups.restore');
    Route::prefix('tests')->name('tests.')->group(function () {
        Route::resource('questions', QuestionController::class);
        Route::post('questions/{question}/restore', [QuestionController::class, 'restore'])->name('questions.restore');
        Route::post('/questions/{question}/answer-sequence', [AnswerController::class, 'updateAnswerSequence'])->name('questions.answer_sequence');

        Route::prefix('questions')->name('questions.')->group(function () {
            Route::resource('answers', AnswerController::class);
            Route::post('/answers/{answer}/restore', [AnswerController::class, 'restore'])->name('answers.restore');

            Route::prefix('answers')->name('answers.')->group(function () {
                Route::resource('reactions', ReactionController::class);
            });
        });
        Route::resource('variables', VariableController::class);
        Route::post('/variables/{variable}/restore', [VariableController::class, 'restore'])->name('variables.restore');
        Route::resource('results', ResultController::class);
    });
    Route::resource('tests', TestController::class);

    Route::post('/tests/{test}/restore', [TestController::class, 'restore'])->name('tests.restore');
    Route::post('/tests/{test}/question-sequence', [QuestionController::class, 'updateQuestionSequence'])->name('tests.question_sequence');
    Route::post('/tests/{test}/result-sequence', [ResultController::class, 'updateResultSequence'])->name('tests.result_sequence');
    Route::get('/tests/{test}/publish', [TestController::class, 'publish'])->name('tests.publish');
    Route::get('/tests/{test}/return-draft', [TestController::class, 'returnTestToDraft'])->name('tests.return_draft');
    Route::get('/tests/{test}/moderation', [TestController::class, 'submitForModeration'])
        ->name('tests.submit_moderation');
    Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');

});
