<?php

namespace App\Enums;

enum DebtStatusEnum: int
{
    case IMPORTED = 1;
    case GENERATED = 2; // Payment Slip
    case SENDED = 3; // Sended email
}
