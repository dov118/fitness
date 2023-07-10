<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Group;
use App\Models\Muscle;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard.index', [
            'muscles' => Muscle::with('group')->get()->all(),
            'groups' => Group::all(),
            'exercises' => Exercise::all(),
        ]);
    }
}
