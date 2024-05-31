<?php

namespace App\Observers;

use App\Models\AdminNote;
use Illuminate\Support\Facades\Auth;

class AdminNoteObserver
{
    /**
     * Handle the AdminNote "creating" event.
     */
    public function creating(AdminNote $adminNote): void
    {
        $adminNote->admin_id = Auth::user('admin')->id;
    }

 

    /**
     * Handle the AdminNote "updated" event.
     */
    public function updated(AdminNote $adminNote): void
    {
        //
    }

    /**
     * Handle the AdminNote "deleted" event.
     */
    public function deleted(AdminNote $adminNote): void
    {
        //
    }

    /**
     * Handle the AdminNote "restored" event.
     */
    public function restored(AdminNote $adminNote): void
    {
        //
    }

    /**
     * Handle the AdminNote "force deleted" event.
     */
    public function forceDeleted(AdminNote $adminNote): void
    {
        //
    }
}
