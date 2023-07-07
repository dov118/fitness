<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    use HasFactory;

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function sets(): BelongsToMany
    {
        return $this->belongsToMany(Set::class);
    }
}
