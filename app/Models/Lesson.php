<?php

namespace App\Models;

use App\Http\Trait\Statusable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, Statusable;

    protected $guarded = [];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

}
