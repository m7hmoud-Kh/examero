<?php
namespace App\Http\Trait;

trait Statusable
{

    public function scopeStatus($query)
    {
        return $query->where('status',true);
    }
}
