<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AdminNote;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\TeacherNote;
use App\Models\User;
use App\Models\UserNote;
use App\Observers\AdminNoteObserver;
use App\Observers\AdminObserver;
use App\Observers\QuestionObserver;
use App\Observers\TeacherNoteObserver;
use App\Observers\TeacherObserver;
use App\Observers\UserNoteObserver;
use App\Observers\UserObserver;
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
        User::observe(UserObserver::class);
        TeacherNote::observe(TeacherNoteObserver::class);
        UserNote::observe(UserNoteObserver::class);
    }
}
