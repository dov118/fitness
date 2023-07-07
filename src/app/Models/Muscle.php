<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Muscle extends Model
{
    use HasFactory;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }
}
