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
            'muscles' => Muscle::with('group')->get()->all(),
            'groups' => Group::all(),
            'exercises' => Exercise::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.muscle.create', [
            'groups' => Group::all('id', 'name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMuscleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Muscle::create($validated);

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
            'groups' => Group::all('id', 'name'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Muscle $muscle): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.muscle.edit', [
            'muscle' => $muscle,
            'groups' => Group::all('id', 'name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMuscleRequest $request, Muscle $muscle): RedirectResponse
    {
        $validated = $request->validated();
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
