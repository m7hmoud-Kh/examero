<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AdminNote;
use App\Models\Question;
use App\Models\Teacher;
use App\Observers\AdminNoteObserver;
use App\Observers\AdminObserver;
use App\Observers\QuestionObserver;
use App\Observers\TeacherObserver;
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
        Teacher::observe(TeacherObserver::class);
        Question::observe(QuestionObserver::class);
    }
}
