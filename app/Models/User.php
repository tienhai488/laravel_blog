<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enum\UserRuleEnum;
use App\Enum\UserStatusEnum;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    // protected function name(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (mixed $value, array $attributes) => $attributes['last_name'].' '.$attributes['first_name'],
    //     );
    // }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_name.' '.$this->first_name,
        );
    }

    public function Posts(){
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    protected $casts = [
        'role' => UserRuleEnum::class,
        'status' => UserStatusEnum::class,
    ];
}