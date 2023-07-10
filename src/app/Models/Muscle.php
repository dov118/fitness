<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Muscle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'group_id',
    ];

    protected $appends = [
        'intensities',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }

    protected function getIntensitiesAttribute(): array
    {
        $return = [];

        foreach (DB::table('exercise_muscle')
                     ->where('muscle_id', $this->id)
                     ->get(['intensity', 'exercise_id']) as $item) {
            $return[$item->exercise_id] = $item->intensity;
        }

        return $return;
    }

    public function setIntensity(int $exercise_id, float $intensity): void
    {
        DB::table('exercise_muscle')
            ->where('exercise_id', $exercise_id)
            ->where('muscle_id', $this->id)
            ->update(['intensity' => $intensity]);
    }
}
