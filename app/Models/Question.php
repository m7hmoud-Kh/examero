<?php

namespace App\Models;

use App\Enums\Question\QuestionForWhom;
use App\Enums\Question\QuestionLevel;
use App\Enums\Question\QuestionSemster;
use App\Enums\Question\QuestionStatus;
use App\Http\Trait\ActivityLogger;
use App\Services\ActivityServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Question extends Model
{
    use HasFactory,LogsActivity, ActivityLogger ;

    public const PATH_IMAGE = '/assets/Questions/';
    public const DISK_NAME = 'question';

    protected $guarded = [];

    public $activity;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $this->activity = new ActivityServices();
        $this->activity->tapActivity($activity, $eventName, 'Question');
    }

    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    public function adminQuestion()
    {
        return $this->hasOne(AdminQuestion::class);
    }

    public function teacherQuestion()
    {
        return $this->hasOne(TeacherQuestion::class);
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }


    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public static function getForWhomName($for)
    {

        switch ($for) {
            case QuestionForWhom::BOTH->value:
                return [QuestionForWhom::BOTH->value, 'both'];
            break;
            case QuestionForWhom::FEMALE->value:
                return [QuestionForWhom::FEMALE->value, 'female'];
            break;
            case QuestionForWhom::MALE->value:
                return [QuestionForWhom::MALE->value, 'male'];
            break;
            default:
                # code...
                break;
        }
    }

    public static function getStatusName($status)
    {

        switch ($status) {
            case QuestionStatus::WAITING->value:
                return [QuestionStatus::WAITING->value, 'waiting'];
            break;
            case QuestionStatus::ACCPTED->value:
                return [QuestionStatus::ACCPTED->value, 'accpted'];
            break;
            case QuestionStatus::REJECTED->value:
                return [QuestionStatus::REJECTED->value, 'rejected'];
            break;
            default:
                # code...
                break;
        }
    }

    public static function getLevelName($level)
    {
        switch ($level) {
            case QuestionLevel::EASY->value:
                return [QuestionLevel::EASY->value, 'easy'];
            break;
            case QuestionLevel::MEDIUM->value:
                return [QuestionLevel::MEDIUM->value, 'medium'];
            break;
            case QuestionLevel::HARD->value:
                return [QuestionLevel::HARD->value, 'hard'];
            break;
            case QuestionLevel::HIGER_THING_SKILLS->value:
                return [QuestionLevel::HIGER_THING_SKILLS->value, 'Higer Thing Skills'];
            break;
            case QuestionLevel::EXTERNAL_QUESTION->value:
                return [QuestionLevel::EXTERNAL_QUESTION->value, 'External Question'];
            break;
            default:
                # code...
                break;
        }
    }

    public static function getSemsterName($semster)
    {

        switch ($semster) {
            case QuestionSemster::FIRST_SEMSTER->value:
                return [QuestionSemster::FIRST_SEMSTER->value, 'First Semster'];
            break;
            case QuestionSemster::SECOND_SEMSTER->value:
                return [QuestionSemster::SECOND_SEMSTER->value, 'Second Semster'];
            break;
            default:
                # code...
                break;
        }
    }

}
