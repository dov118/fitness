<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.group.index', [
            'groups' => Group::with('muscles')->get()->all(),
            'muscles' => Muscle::all(),
            'exercises' => Exercise::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGroupRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Group::create($validated);

        return to_route('admin.group.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Muscle group successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.group.show', [
            'group' => $group,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.group.edit', [
            'group' => $group,
            'muscles' => Muscle::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
        $validated = $request->validated();

        // Dissociate existing muscles
        $group->muscles->each(fn ($muscle) => $muscle->group()->dissociate()->save());

        // Get params staring by 'muscle_'
        $keys = array_filter(array_keys($request->all()), fn ($key) => str_starts_with($key, 'muscle_'));

        // Check filtered keys as 'on'
        $checkedKeys = array_filter($keys, fn ($key)=> $request->all()[$key] === 'on' );

        // Get id for each param key
        $ids = array_map(fn ($key) => (int)str_replace('muscle_', '', $key), $checkedKeys);

        // Get muscles from id list
        $muscles = Muscle::whereIn('id', $ids)->get();

        // Associate selected muscles
        $muscles->each(fn ($muscle) => $muscle->group()->associate($group)->save());

        // Update group
        $group->update($validated);

        return to_route('admin.group.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Muscle group successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group): RedirectResponse
    {
        if ($group->muscles()->exists()) {
            return to_route('admin.group.index')
                ->with('notification_type', 'error')
                ->with('notification_message', 'Muscle group have attached muscle. It can\'t be deleted');
        }

        $group->delete();

        return to_route('admin.group.index')
            ->with('notification_type', 'success')
            ->with('notification_message', 'Muscle group successfully deleted');
    }
}
