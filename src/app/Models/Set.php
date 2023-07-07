<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Set extends Model
{
    use HasFactory;

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function session(): BelongsToMany
    {
        return $this->belongsToMany(Session::class);
    }
}
