<?php

namespace App\Models;

use App\Enums\TeacherTypePoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPoint extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $casts = [
        'type' => TeacherTypePoint::class,
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
