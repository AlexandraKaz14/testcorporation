<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Moderation;
use App\Models\Test;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(__('common.MAIN NAVIGATION'));
            $event->menu->add([
                'text' => __('common.catalog tests'),
                'url' => route('catalog'),
                'icon' => 'fa fa-list mr-1',
            ]);
            $event->menu->add([
                'text' => __('common.profile'),
                'url' => route('profile'),
                'icon' => 'fa fa-user mr-1',
                'active' => ['profile*'],
            ]);
        });
        $this->adminMenu();
        $this->authorMenu();
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add([
                'text' => __('common.instruction'),
                'url' => route('instruction'),
                'icon' => 'fa fa-paragraph mr-1',
                'active' => ['instruction*'],
            ]);
        });
    }

    private function adminMenu()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (!Auth::user() || !Auth::user()->isAdmin()) {
                return;
            }

            $event->menu->add([
                'text' => __('common.users'),
                'url' => route('admin.users.index', [
                    'deletedStatuses[]' => User::DELETED_STATUS_LIVE,
                ]),
                'icon' => 'fas fa-fw fa-users mr-1',
                'active' => ['admin/users*'],
            ]);
            $event->menu->add([
                'text' => __('common.categories'),
                'url' => route('admin.categories.index'),
                'icon' => 'fa fa-tags mr-1',
                'active' => ['admin/categories*'],
            ]);
            $event->menu->add([
                'text' => __('common.tests'),
                'url' => route('admin.tests.index', [
                    'deletedStatuses[]' => Test::STATUS_UNDELETED,
                ]),
                'icon' => 'fa fa-graduation-cap mr-1',
                'active' => ['admin/tests*'],
            ]);

            $moderationCount = Moderation::where('moderation_status', Moderation::MODERATION_STATUS_PENDING)->count();

            $event->menu->add([
                'text' => __('common.moderation tests'),
                'url' => route('admin.moderations.index'),
                'icon' => 'fa fa-check mr-1',
                'active' => ['admin/moderations*'],
                'label' => $moderationCount > 0 ? $moderationCount : null,
                'label_color' => 'warning',
            ]);

            $event->menu->add([
                'text' => __('common.themes'),
                'url' => route('admin.themes.index'),
                'icon' => 'fa fa-paint-brush mr-1',
                'active' => ['admin/themes*'],

            ]);
            $event->menu->add([
                'text' => __('common.groups'),
                'url' => route('admin.groups.index'),
                'icon' => 'fa fa-list mr-1',
                'active' => ['admin/groups*'],
            ]);
            $event->menu->add([
                'text' => __('common.audit'),
                'url' => route('admin.audits.index'),
                'icon' => 'fa fa-history mr-1',
                'active' => ['admin/audits*'],
            ]);

        });

    }

    private function authorMenu()
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            if (!Auth::user() || !Auth::user()->isAuthor()) {
                return;
            }
            $event->menu->add([
                'text' => __('common.tests'),
                'url' => route('author.tests.index', [
                    'deletedStatuses[]' => Test::STATUS_UNDELETED,
                ]),
                'active' => ['author/tests*'],
                'icon' => 'fa fa-graduation-cap mr-1',
            ]);

        });

    }
}
