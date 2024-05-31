<?php

namespace App\Enums;


enum TypePoint: string {
    case REWARD = '1';
    case PUNISHMENT = '2';
    case WARNING = '3';
    case NOTHING = '4';
}
