<?php

namespace App\Enums;


enum OpenEmisStatus: int {
    case WAITING = 1;
    case RECEIVED = 2;
    case ENDED = 3;
}
