@php use App\Models\Group; @endphp
@php use App\Models\Muscle; @endphp
<nav class="menu" aria-labelledby="menu-heading">
    <span class="menu-heading" id="menu-heading">General</span>
    <a class="menu-item" @if('admin.index' === Route::current()->getName()) aria-current="page" @endif href="{{ route('admin.index') }}">Dashboard</a>
    <hr class="SelectMenu-divider">
    <span class="menu-heading" id="menu-heading">Muscles</span>
    @can('viewAny', Muscle::class)<a class="menu-item" @if('admin.muscle.index' === Route::current()->getName()) aria-current="page" @endif href="{{ route('admin.muscle.index') }}"><span class="Counter">{{ count($muscles ?? []) ?: '??' }}</span>All</a>@endcan
    @can('viewAny', Group::class)<a class="menu-item" @if('admin.group.index' === Route::current()->getName()) aria-current="page" @endif href="{{ route('admin.group.index') }}"><span class="Counter">{{ count($groups ?? []) ?: '??' }}</span>  Groups</a>@endcan
</nav>
