<?php

namespace App\Observers;

use App\Models\UserNote;
use Illuminate\Support\Facades\Auth;

class UserNoteObserver
{
    /**
     * Handle the UserNote "created" event.
     */
    public function creating(UserNote $userNote): void
    {
        //
        $userNote->user_id = Auth::guard('api')->user()->id;

    }

    /**
     * Handle the UserNote "updated" event.
     */
    public function updated(UserNote $userNote): void
    {
        //
    }

    /**
     * Handle the UserNote "deleted" event.
     */
    public function deleted(UserNote $userNote): void
    {
        //
    }

    /**
     * Handle the UserNote "restored" event.
     */
    public function restored(UserNote $userNote): void
    {
        //
    }

    /**
     * Handle the UserNote "force deleted" event.
     */
    public function forceDeleted(UserNote $userNote): void
    {
        //
    }
}
