<?php

namespace App\Models;

use ArrayAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'order'];

    public static function findOrCreate(string | array | ArrayAccess $values): Collection | Tag | static
    {
        $tags = collect($values)->map(function ($value) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function findFromString(string $title)
    {
        return static::query()
            ->where('title', $title)
            ->first();
    }

    protected static function findOrCreateFromString(string $title)
    {
        $tag = static::findFromString($title);

        if (! $tag) {
            $tag = static::query()->create(['title' => $title]);
        }

        return $tag;
    }
}
