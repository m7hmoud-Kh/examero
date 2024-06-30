<?php

namespace App\Models;

use App\Enums\TeacherServicesType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPlanDetails extends Model
{
    use HasFactory;
    protected $guarded = [];



    public static function getTypeName($status)
    {

        switch ($status) {
            case TeacherServicesType::EXAM->value:
                return [ TeacherServicesType::EXAM->value, 'Exam'];
            break;
            case  TeacherServicesType::OPENEMIS->value:
                return [ TeacherServicesType::OPENEMIS->value, 'Open Emis'];
            break;
            case  TeacherServicesType::CERTIFICATE->value:
                return [ TeacherServicesType::CERTIFICATE->value, 'certificate'];
            break;

            case  TeacherServicesType::SPECIFICATION->value:
                return [ TeacherServicesType::SPECIFICATION->value, 'Specification'];
            break;
            default:
                # code...
                break;
        }
    }


}
