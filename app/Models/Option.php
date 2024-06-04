<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $guarded = [];

    public const PATH_IMAGE = '/assets/Options/';
    public const DISK_NAME = 'option';


    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }
}
