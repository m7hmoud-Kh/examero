<?php

namespace App\Enums;


enum TeacherPoint: int {
    case EXAM = 50;
    case QUESTION = 1;
    case OPENEMIS = 20;
    case CERTIFICATE = 10;
    case SPECIFICATION=30;
    case BASIC_QUESTION=25;
}
