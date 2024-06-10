<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory, Statusable;
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'students_plans',
            'plan_id',
            'user_id'
        )->withTimestamps()->withPivot(['exam_used','status']);
    }
}
