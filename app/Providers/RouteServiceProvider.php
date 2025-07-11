<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();
        $this->loade();
    }

    protected function loade()
    {

        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                Route::middleware('web')->group(base_path('routes/web.admin.php'));
            }
            //            if (auth()->user()->isAuthor()) {
            //                Route::middleware('web')->group(base_path('routes/web.author.php'));
            //            }
        }
    }
}
