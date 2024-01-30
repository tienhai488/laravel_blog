<?php

namespace App\Models;

use App\Enum\PostStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $with = ['media'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $casts = [
        'status' => PostStatusEnum::class,
    ];

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl(),
        );
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("media")
            ->singleFile();

        $this->addMediaCollection("thumbnail")
            ->singleFile();
    }

    public function media(): MorphMany
    {
        return $this->morphMany(config('media-library.media_model'), 'model');
    }

    public function scopeIsPending($query)
    {
        return $query->where('status', PostStatusEnum::PENDING)->exists();
    }

    public function scopeIsApproved($query)
    {
        return $query->where('status', PostStatusEnum::APPROVED)->exists();
    }

    public function scopeIsDenied($query)
    {
        return $query->where('status', PostStatusEnum::DENIED)->exists();
    }

    protected $fillable = [
        'title',
        'slug',
        'status',
        'description',
        'content',
        'publish_date',
    ];
}
