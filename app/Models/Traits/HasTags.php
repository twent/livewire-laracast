<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Tag;
use ArrayAccess;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;

trait HasTags
{
    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(Tag::class, 'taggable')
            ->orderBy('order');
    }

    public function attachTags(array | ArrayAccess | Tag $tags): static
    {
        $tags = collect(Tag::findOrCreate($tags));

        $this->tags()->syncWithoutDetaching(
            $tags->pluck('id')->toArray()
        );

        return $this;
    }

    public function attachTag(string | Tag $tag)
    {
        return $this->attachTags([$tag]);
    }

    public function detachTags(array | ArrayAccess $tags): static
    {
        $tags = static::convertToTags($tags);

        collect($tags)->filter()->each(
            fn (Tag $tag) => $this->tags()->detach($tag)
        );

        return $this;
    }

    public function detachTag(string | Tag $tag): static
    {
        return $this->detachTags([$tag]);
    }

    public function syncTags(string | array | ArrayAccess $tags): static
    {
        if (is_string($tags)) {
            $tags = Arr::wrap($tags);
        }

        $tags = collect(Tag::findOrCreate($tags));

        $this->tags()->sync(
            $tags->pluck('id')->toArray()
        );

        return $this;
    }

    protected static function convertToTags($values)
    {
        if ($values instanceof Tag) {
            $values = [$values];
        }

        return collect($values)->map(function ($value) {
            if ($value instanceof Tag) {
                return $value;
            }

            return Tag::findFromString($value);
        });
    }
}
