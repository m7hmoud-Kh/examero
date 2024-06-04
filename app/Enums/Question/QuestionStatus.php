<?php

namespace App\Enums\Question;


enum QuestionStatus :int {
    case WAITING = 1;
    case ACCPTED = 2;
    case REJECTED = 3;
}
