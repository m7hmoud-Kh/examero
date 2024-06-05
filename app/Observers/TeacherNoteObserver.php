<?php

namespace App\Observers;

use App\Models\TeacherNote;
use Illuminate\Support\Facades\Auth;

class TeacherNoteObserver
{
    /**
     * Handle the TeacherNote "created" event.
     */
    public function creating(TeacherNote $teacherNote): void
    {
        $teacherNote->teacher_id = Auth::guard('teacher')->user()->id;
    }

    /**
     * Handle the TeacherNote "updated" event.
     */
    public function updated(TeacherNote $teacherNote): void
    {
        //
    }

    /**
     * Handle the TeacherNote "deleted" event.
     */
    public function deleted(TeacherNote $teacherNote): void
    {
        //
    }

    /**
     * Handle the TeacherNote "restored" event.
     */
    public function restored(TeacherNote $teacherNote): void
    {
        //
    }

    /**
     * Handle the TeacherNote "force deleted" event.
     */
    public function forceDeleted(TeacherNote $teacherNote): void
    {
        //
    }
}
