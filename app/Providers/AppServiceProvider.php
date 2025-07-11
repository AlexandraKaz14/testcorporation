<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\TelegramErrorNotificationService;
use App\View\Composers\AuditComposer;
use App\View\Composers\CurrentUserComposer;
use App\View\Composers\GroupComposer;
use App\View\Composers\ModerationComposer;
use App\View\Composers\QuestionComposer;
use App\View\Composers\ReactionComposer;
use App\View\Composers\TestComposer;
use App\View\Composers\UserComposer;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Yandex\Provider as YandexProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->bind(TelegramErrorNotificationService::class, function () {
            return new TelegramErrorNotificationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['admin.tests.index', 'admin.tests.create', 'admin.tests.edit'], TestComposer::class);
        View::composer(['admin.users.index', 'admin.users.create', 'admin.users.edit'], UserComposer::class);
        View::composer(['admin.questions.create', 'admin.questions.edit'], QuestionComposer::class);
        View::composer(['admin.reactions.create', 'admin.reactions.edit', 'admin.answers.show', 'admin.questions.show'], ReactionComposer::class);
        Paginator::defaultView('vendor.pagination.bootstrap-4');
        View::composer(['admin.groups.create', 'admin.groups.edit'], GroupComposer::class);
        View::composer('*', CurrentUserComposer::class);
        View::composer(['admin.audits.index'], AuditComposer::class);
        View::composer(['admin.moderations.index'], ModerationComposer::class);

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('yandex', YandexProvider::class);
        });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {

            return (new MailMessage())
                ->subject('Подтвердите адрес электронной почты')
                ->greeting('Здравствуйте!')
                ->line('Нажмите кнопку ниже, чтобы подтвердить свой адрес электронной почты.')
                ->action('Подтвердить', $url)
                ->line('Если вы не создавали учетную запись, пожалуйста, проигнорируйте это письмо. Никаких действий с вашей стороны не требуется.');
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->email,
            ], false));
            return (new MailMessage())
                ->subject('Уведомление о сбросе пароля')
                ->greeting('Здравствуйте!')
                ->line('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
                ->action('Сбросить пароль', $url)
                ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.');
        });

        RateLimiter::for('change-password', function ($request) {
            return Limit::perDay(3)->by($request->user()->id)
                ->response(function () {
                    return redirect()->back()
                        ->withErrors('Вы слишком часто меняете пароль! Допустимое количество 3 раза в течение 24 часов');
                });
        });

        if (env('APP_INDEXABLE') === false || env('APP_INDEXABLE') === 'false') {
            // Добавляем заголовок ко всем HTTP-ответам
            app('router')
                ->matched(function () {
                    app()->terminating(function () {
                        if (!headers_sent()) {
                            header('X-Robots-Tag: noindex, nofollow');
                        }
                    });
                });

            // Пробрасываем переменную в Blade
            View::share('metaNoIndex', true);
        }
    }
}
