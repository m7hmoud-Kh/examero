<?php

namespace App\Enums\Question;


enum QuestionForWhom :int {
    case BOTH = 1;
    case MALE = 2;
    case FEMALE = 3;
}
