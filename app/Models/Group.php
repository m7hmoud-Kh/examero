<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Subset;

class Group extends Model
{
    use HasFactory, Statusable;
    protected $guarded = [];

    public function subjects()
    {
        return $this->belongsToMany(
            Subset::class,
            'groups_subjects',
            'group_id',
            'subject_id'
        );
    }



}
