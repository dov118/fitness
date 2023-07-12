<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMuscleRequest;
use App\Http\Requests\UpdateMuscleRequest;
use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class MuscleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.muscle.index', [
            'muscles' => Muscle::all(),
            'groups' => Group::with(['muscles' => fn ($q) => $q->with(['exercises' => fn($q) => $q->withPivot('intensity')->orderBy('pivot_intensity', 'desc')->whereNot('intensity', 0.0)])->get()->all()])->get()->all(),
            'exercises' => Exercise::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.muscle.create', [
            'groups' => Group::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMuscleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $muscle = Muscle::create($validated);
        Exercise::all()->each(fn ($exercise) => $muscle->exercises()->attach($exercise->id));

        return to_route('admin.muscle.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Muscle successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Muscle $muscle): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.muscle.show', [
            'muscle' => $muscle,
            'groups' => Group::all(),
            'active_exercises' => $muscle->exercises()->orderBy('name', 'desc')->withPivot('intensity')->whereNot('intensity', 0.0)->get()->reverse(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Muscle $muscle): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.muscle.edit', [
            'muscle' => $muscle,
            'groups' => Group::all(),
            'active_exercises' => $muscle->exercises()
                ->withPivot('intensity')
                ->whereNot('intensity', 0.0)
                ->orderBy('pivot_intensity')
                ->get()
                ->reverse(),
            'inactive_exercises' => $muscle->exercises()
                ->orderBy('name', 'desc')
                ->withPivot('intensity')
                ->where('intensity', 0.0)
                ->get()
                ->reverse(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMuscleRequest $request, Muscle $muscle): RedirectResponse
    {
        $validated = $request->validated();

        // Get params staring by 'option-'
        $keys = array_filter(array_keys($request->all()), fn ($key) => str_starts_with($key, 'option-'));

        // Get id and value for each param key
        $exercises = [];
        foreach ($keys as $key) {
            $exercises[(int)str_replace('option-', '', $key)] = (float)$request->all()[$key];
        }

        // Update intensity value for each exercises
        foreach ($exercises as $exercise_id=>$intensity) {
            $muscle->exercises()->updateExistingPivot($exercise_id, ['intensity' => $intensity]);
        }

        $muscle->update($validated);

        return to_route('admin.muscle.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Muscle successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Muscle $muscle): RedirectResponse
    {
        if ($muscle->exercises()->exists()) {
            return to_route('admin.muscle.index')
                ->with('notification_type', 'error')
                ->with('notification_message', 'Muscle have attached exercise. It can\'t be deleted');
        }

        $muscle->delete();

        return to_route('admin.muscle.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Muscle successfully deleted');
    }
}
