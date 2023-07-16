@php use App\Models\Group; @endphp
@php use App\Models\Muscle; @endphp
@php use App\Models\Exercise; @endphp
<nav class="menu sidenav" aria-labelledby="menu-heading">
    <span class="menu-heading menu-heading--general" id="menu-heading">General</span>
    <a
        class="menu-item menu-item--dashboard"
        @if('admin.index' === Route::current()->getName()) aria-current="page" @endif
        href="{{ route('admin.index') }}">Dashboard</a>
    <hr class="SelectMenu-divider">
    @can('viewAny', Muscle::class)
        <a
            class="menu-item menu-item--muscle"
            @if(str_contains(Route::getCurrentRoute()->getControllerClass(), 'MuscleController'))
                aria-current="page"
            @endif
            href="{{ route('admin.muscle.index') }}"
        >
            <span class="Counter menu-item--muscle-count">{{ count($muscles ?? []) ?: '??' }}</span>
            Muscles
        </a>
    @endcan
    @can('viewAny', Group::class)
        <a
            class="menu-item menu-item--group"
            @if(str_contains(Route::getCurrentRoute()->getControllerClass(), 'GroupController'))
                aria-current="page"
            @endif
            href="{{ route('admin.group.index') }}"
        >
            <span class="Counter menu-item--group-count">{{ count($groups ?? []) ?: '??' }}</span>
            Groups</a>
    @endcan
    <hr class="SelectMenu-divider">
    @can('viewAny', Exercise::class)
        <a
            class="menu-item menu-item--exercise"
            @if(str_contains(Route::getCurrentRoute()->getControllerClass(), 'ExerciseController'))
                aria-current="page"
            @endif
            href="{{ route('admin.exercise.index') }}"
        >
            <span class="Counter menu-item--exercise-count">{{ count($exercises ?? []) ?: '??' }}</span>
            Exercises
        </a>
    @endcan
</nav>
