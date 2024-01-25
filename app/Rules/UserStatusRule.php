<?php

namespace App\Rules;

use App\Enum\UserStatusEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserStatusRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(UserStatusEnum::getDescription($value) == ''){
            $fail('Trạng thái không hợp lệ vui lòng kiểm tra lại!');
        }
    }
}
