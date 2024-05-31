<?php

namespace App\Models;

use App\Enums\TypePoint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPoint extends Model
{
    use HasFactory;
    protected $guarded = [];


    protected $casts = [
        'type' => TypePoint::class,
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
