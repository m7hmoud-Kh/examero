<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
