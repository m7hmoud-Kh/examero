<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory, Statusable;
    protected $guarded = [];


    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'groups_subjects',
            'subject_id',
            'group_id'
        );
    }

}
