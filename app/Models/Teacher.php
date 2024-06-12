<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Teacher extends Authenticatable implements JWTSubject

{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public const PATH_IMAGE = '/assets/Teacher/';
    public const DISK_NAME = 'teacher';


    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
