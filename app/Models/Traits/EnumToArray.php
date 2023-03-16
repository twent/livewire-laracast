<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Support\Arr;

trait EnumToArray
{
    public static function values(): array
    {
        return Arr::map(static::cases(), fn ($enum) => $enum->value);
    }
}
