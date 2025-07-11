<?php

declare(strict_types=1);

namespace App\View\Composers;

use App\Models\CustomAudit;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AuditComposer
{
    public function compose(View $view)
    {
        $events = CustomAudit::EVENTS;
        $users = User::query()->orderBy('name')->get();

        $models = Cache::remember('audit_models', 3600, function () {
            return CustomAudit::select('auditable_type')
                ->distinct()
                ->orderBy('auditable_type')
                ->get();
        });

        $view->with([
            'events' => $events,
            'users' => $users,
            'models' => $models,
        ]);
    }
}
