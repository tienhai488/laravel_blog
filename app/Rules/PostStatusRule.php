<?php

namespace App\Rules;

use App\Enum\PostStatusEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostStatusRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(PostStatusEnum::getDescription($value) == ""){
            $fail("Trạng thái không hợp lệ vui lòng kiểm tra lại!");
        }
    }
}
