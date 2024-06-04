<?php

namespace App\Observers;

use App\Http\Trait\Imageable;
use App\Models\Option;
use App\Models\Question;

class QuestionObserver
{
    use Imageable;
    /**
     * Handle the Question "created" event.
     */

    public function created(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "updated" event.
     */
    public function updated(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "deleted" event.
     */
    public function deleted(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "restored" event.
     */
    public function restored(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     */
    public function forceDeleted(Question $question): void
    {
        //
    }
}
