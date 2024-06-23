<?php

namespace App\Enums;


enum PaymentType: string {
    case PAYAPL = 'paypal';
    case VISA = 'visa';
}
