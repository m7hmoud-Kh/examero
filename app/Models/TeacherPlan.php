<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPlan extends Model
{
    use HasFactory, Statusable;
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(TeacherPlanDetails::class,'teacher_plans_id','id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
