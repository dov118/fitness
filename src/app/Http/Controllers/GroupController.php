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
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGroupRequest $request, Group $group): RedirectResponse
    {
        $validated = $request->validated();
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
