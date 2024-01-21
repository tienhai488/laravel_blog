<?php
namespace App\Enum;

enum PostStatusEnum : int {
    case PENDING = 0;
    case APPROVED = 1;
    case DENIED = 2;
}