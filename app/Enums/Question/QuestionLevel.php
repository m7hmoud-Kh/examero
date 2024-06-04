<?php

namespace App\Enums\Question;


enum QuestionLevel :int {
    case EASY = 1;
    case MEDIUM = 2;
    case HARD = 3;
    case HIGER_THING_SKILLS = 4;
    case EXTERNAL_QUESTION = 5;
}
