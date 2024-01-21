<?php

namespace App\Models;

use App\Enum\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function User(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $casts = [
        'status' => PostStatusEnum::class,
    ];
}