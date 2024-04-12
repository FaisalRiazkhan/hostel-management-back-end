<?php

namespace App\Enums;

enum RentStatus: int
{
    case UNPAID = 0;
    case PAID = 1;
}