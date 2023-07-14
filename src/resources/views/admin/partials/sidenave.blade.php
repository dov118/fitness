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
            @if('admin.muscle.index' === Route::current()->getName()) aria-current="page" @endif
            href="{{ route('admin.muscle.index') }}"
        >
            <span class="Counter">{{ count($muscles ?? []) ?: '??' }}</span>
            Muscles
        </a>
    @endcan
    @can('viewAny', Group::class)
        <a
            class="menu-item menu-item--group"
            @if('admin.group.index' === Route::current()->getName()) aria-current="page" @endif
            href="{{ route('admin.group.index') }}"
        >
            <span class="Counter">{{ count($groups ?? []) ?: '??' }}</span>
            Groups</a>
    @endcan
    <hr class="SelectMenu-divider">
    @can('viewAny', Exercise::class)
        <a
            class="menu-item menu-item--exercise"
            @if('admin.exercise.index' === Route::current()->getName()) aria-current="page" @endif
            href="{{ route('admin.exercise.index') }}"
        >
            <span class="Counter">{{ count($exercises ?? []) ?: '??' }}</span>
            Exercises
        </a>
    @endcan
</nav>
