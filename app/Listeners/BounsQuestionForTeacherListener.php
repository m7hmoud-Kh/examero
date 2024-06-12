<?php

namespace App\Listeners;

use App\Enums\TeacherPoint;
use App\Events\BounsQuestionEvent;
use App\Models\Teacher;
use Illuminate\Container\BoundMethod;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BounsQuestionForTeacherListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BounsQuestionEvent $event): void
    {
        $question = $event->question;
        $teacherId = $question->teacherQuestion->teacher_id;
        $teacher = Teacher::find($teacherId);
        $teacher->update([
            'rewarded_point' => $teacher->rewarded_point + (TeacherPoint::EXAM->value / 50)
        ]);
    }
}
