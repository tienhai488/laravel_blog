<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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

    public function scopeIsPending($query)
    {
        return $query->where('status', UserStatusEnum::PENDING)->exists();
    }

    public function scopeIsApproved($query)
    {
        return $query->where('status', UserStatusEnum::APPROVED)->exists();
    }

    public function scopeIsDenied($query)
    {
        return $query->where('status', UserStatusEnum::DENIED)->exists();
    }

    public function scopeIsLocked($query)
    {
        return $query->where('status', UserStatusEnum::LOCKED)->exists();
    }
}
