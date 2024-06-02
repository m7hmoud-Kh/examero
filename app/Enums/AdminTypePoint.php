<?php

namespace App\Enums;


enum AdminTypePoint: string {
    case REWARD = '1';
    case PUNISHMENT = '2';
    case WARNING = '3';
    case NOTHING = '4';
}
