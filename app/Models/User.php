<?php

namespace App\Models;

use App\Enum\UserRoleEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enum\UserStatusEnum;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->last_name . ' ' . $this->first_name,
        );
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    protected $casts = [
        'role' => UserRoleEnum::class,
        'status' => UserStatusEnum::class,
    ];

    public function isPending()
    {
        return $this->status == UserStatusEnum::PENDING;
    }

    public function isApproved()
    {
        return $this->status == UserStatusEnum::APPROVED;
    }

    public function isDenied()
    {
        return $this->status == UserStatusEnum::DENIED;
    }

    public function isLocked()
    {
        return $this->status == UserStatusEnum::LOCKED;
    }

    public function isAdmin()
    {
        return $this->role == UserRoleEnum::ADMIN;
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'status',
    ];
}