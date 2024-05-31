<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AdminNote;
use App\Observers\AdminNoteObserver;
use App\Observers\AdminObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        AdminNote::observe(AdminNoteObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
