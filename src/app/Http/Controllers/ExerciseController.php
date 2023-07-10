<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.exercise.index', [
            'exercises' => Exercise::with('files')
                ->with('muscles', fn ($query) => $query->orderBy('intensity', 'desc'))
                ->get()
                ->all(),
            'muscles' => Muscle::all(),
            'groups' => Group::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.exercise.create', [
            'exercises' => Exercise::all('id', 'name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Exercise::create($validated);

        return to_route('admin.exercise.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Exercise successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.exercise.show', [
            'exercise' => Exercise::with('files')->find($exercise->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.exercise.edit', [
            'exercise' => $exercise,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise): RedirectResponse
    {
        $validated = $request->validated();
        $exercise->update($validated);

        return to_route('admin.exercise.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Exercise successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise): RedirectResponse
    {
        $exercise->delete();

        return to_route('admin.exercise.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Exercise successfully deleted');
    }
}
