<?php

namespace App\Models;

use App\Enums\OpenEmisStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenEmis extends Model
{
    use HasFactory;

    public const PATH_IMAGE = '/assets/OpenEmis/';
    public const DISK_NAME = 'openEmis';

    protected $guarded = [];



    public function media()
    {
        return $this->morphOne(Media::class,'meddiable');
    }


    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }



    public static function getStatusName($status)
    {

        switch ($status) {
            case OpenEmisStatus::WAITING->value:
                return [OpenEmisStatus::WAITING->value, 'waiting'];
            break;
            case OpenEmisStatus::RECEIVED->value:
                return [OpenEmisStatus::RECEIVED->value, 'received'];
            break;
            case OpenEmisStatus::ENDED->value:
                return [OpenEmisStatus::ENDED->value, 'ended'];
            break;
            default:
                # code...
                break;
        }
    }


}
