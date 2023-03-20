<?php

namespace App\Models;

use App\Models\Scopes\PublishedScope;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'author',
        'thumbnail',
        'intro',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime:Y-m-d\TH:i',
    ];

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                if (str_starts_with($value, 'https')) {
                    return $value;
                }

                return asset("files/$value");
            }
        );
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new PublishedScope());
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->startSlugSuffixFrom(2);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
