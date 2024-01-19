<?php
namespace App\Enum;

enum UserStatusEnum : int {
    case PENDING = 0;
    case APPROVED = 1;
    case DENIED = 2;
    case LOCKED = 3;
}