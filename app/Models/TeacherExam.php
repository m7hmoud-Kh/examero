<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherExam extends Model
{
    use HasFactory;

    public const PATH_IMAGE = '/assets/TeacherExam/';
    public const DISK_NAME = 'teacher_exam';

    protected $guarded = [];


    public function mediaQuestion()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function mediaAnswer()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

}
