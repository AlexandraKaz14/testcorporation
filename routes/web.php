<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\TestPlayerController;
use App\Http\Middleware\DisableTestUserRoleGlobalScope;
use App\Http\Middleware\TestAccessMiddleware;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require base_path('routes/web.admin.php');
require base_path('routes/web.author.php');

Auth::routes([
    'verify' => true,
]);

Auth::routes();

Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('auth/yandex', [LoginController::class, 'redirectToYandex']);
Route::get('auth/yandex/callback', [LoginController::class, 'handleYandexCallback']);

Route::get('auth/vk', [LoginController::class, 'redirectToVk']);
Route::get('auth/vk/callback', [LoginController::class, 'handleVkCallback']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware('throttle:change-password')->patch('profile/update-password', [ProfileController::class, 'updatePassword'])
        ->name('profile.update-password');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/notifications', [ProfileController::class, 'showNotifications'])->name('profile.notifications');

    Route::get('/instruction', [ProfileController::class, 'showPageInstruction'])->name('instruction');

    Route::post('/notifications/read/{notification}', function ($notificationId) {
        $notification = auth()
            ->user()
            ->unreadNotifications()
            ->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    })->name('notifications.markAsRead');
});

Route::middleware([DisableTestUserRoleGlobalScope::class])->group(function () {
    Route::middleware([TestAccessMiddleware::class])->group(function () {
        Route::get('/player/{slug}/metadata', [TestPlayerController::class, 'metaData'])->name('player.meta_data');
        Route::get('/player/{slug}', [TestPlayerController::class, 'open'])->name('player.open');
    });

    Route::get('/player/{slug}/metadata', [TestPlayerController::class, 'metaData'])->name('player.meta_data');
    Route::post('/player/{test}/finish', [TestPlayerController::class, 'finish'])->name('player.finish');
    Route::get('/player/result/{code}', [TestPlayerController::class, 'result'])
        ->name('player.result');

    Route::get('/', [CatalogController::class, 'index'])->name('catalog');
    Route::get('/catalog/tags', [CatalogController::class, 'openTags'])->name('catalog.tags');
    Route::get('/catalog/authors', [CatalogController::class, 'openAuthors'])->name('catalog.authors');
    Route::get('/catalog/groups', [CatalogController::class, 'groupsTests'])->name('catalog.groups');
    Route::get('/catalog/groups/{slug}', [CatalogController::class, 'openGroupTests'])->name('catalog.open_groups');
    Route::get('/catalog/create', [CatalogController::class, 'openPageCreateTest'])->name('catalog.create');
    Route::get('/project', [CatalogController::class, 'openPageAboutProject'])->name('project');
    Route::get('/contacts', [CatalogController::class, 'openPageContact'])->name('contacts');

    Route::post('/contacts/feedback/send', [CatalogController::class, 'feedbackSend'])
        ->name('contacts.feedback.send')
        ->middleware('throttle:3,1');

});
