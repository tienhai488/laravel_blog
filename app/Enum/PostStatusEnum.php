<?php
namespace App\Enum;

enum PostStatusEnum : int {
    case PENDING = 0;
    case APPROVED = 1;
    case DENIED = 2;

    public static function getDescription($status): string {
        switch ($status) {
            case self::PENDING->value:
            case self::PENDING:
                return 'PENDING';
            case self::APPROVED->value:
            case self::APPROVED:
                return 'APPROVED';
            case self::DENIED->value:
            case self::DENIED:
                return 'DENIED';
            default:
                return '';
        }
    }
}