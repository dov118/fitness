<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    public const EMPTY_COUNT = 1;
    public const EMPTY_WEIGHT = 1.5;

    public const EZ_COUNT = 1;
    public const EZ_WEIGHT = 4.5;

    public const BARRE_COUNT = 1;
    public const BARRE_WEIGHT = 5.5;

    public const _0_5_COUNT = 4;
    public const _0_5_WEIGHT = 0.5;

    public const _1_25_COUNT = 4;
    public const _1_25_WEIGHT = 1.25;

    public const _2_5_COUNT = 4;
    public const _2_5_WEIGHT = 2.5;

    public const _5_COUNT = 2;
    public const _5_WEIGHT = 5;

    public function sets(): HasMany
    {
        return $this->hasMany(Set::class);
    }
}
