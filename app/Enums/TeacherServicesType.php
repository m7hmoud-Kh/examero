<?php

namespace App\Enums;


enum TeacherServicesType: int {
    case EXAM = 1;
    case OPENEMIS = 2;
    case CERTIFICATE = 3;
    case SPECIFICATION = 4;
}
