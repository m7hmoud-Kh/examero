<?php

namespace App\Observers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminObserver
{
    /**
     * Handle the Admin "created" event.
     */
    public function creating(Admin $admin): void
    {
        $admin->password = Hash::make($admin->password);
    }

    /**
     * Handle the Admin "updating" event.
     */
    public function updating(Admin $admin): void
    {
        if(request()->has('password')){
            $admin->password = Hash::make($admin->password);
        }
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
