<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guideline',
        'heavy_min',
        'heavy_max',
        'light_min',
        'light_max',
        'duration',
    ];

    public function sets(): HasMany
    {
        return $this->hasMany(Set::class);
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class);
    }

    public function muscles(): BelongsToMany
    {
        return $this->belongsToMany(Muscle::class)->withPivot('intensity');
    }
}
