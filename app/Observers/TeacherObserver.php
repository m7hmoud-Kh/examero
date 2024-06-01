<?php

namespace App\Observers;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherObserver
{
    /**
     * Handle the Teacher "creating" event.
     */
    public function creating(Teacher $teacher): void
    {
        $teacher->password = Hash::make($teacher->password);

    }

    /**
     * Handle the Teacher "updating" event.
     */
    public function updating(Teacher $teacher): void
    {
        if(request()->has('password')){
            $teacher->password = Hash::make($teacher->password);
        }
    }

    /**
     * Handle the Teacher "deleted" event.
     */
    public function deleted(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "restored" event.
     */
    public function restored(Teacher $teacher): void
    {
        //
    }

    /**
     * Handle the Teacher "force deleted" event.
     */
    public function forceDeleted(Teacher $teacher): void
    {
        //
    }
}
