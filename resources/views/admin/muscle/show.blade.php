@extends('admin.layouts.admin')

@section('content')
    <div class="Subhead">
        <h3 class="Subhead-heading content-title">
            {{ $muscle->name }}
        </h3>
        <div class="Subhead-description">
            Intensities:
            <span class="Label mr-1 mt-2 Label--success">100%</span>
            <span class="Label mr-1 mt-2 Label--accent">50%</span>
            <span class="Label mr-1 mt-2 Label--danger">25%</span>
        </div>
        @can('update', $muscle)
            <div class="Subhead-actions">
                <a class="btn btn-primary btn-sm title-edit" href="{{ route('admin.muscle.edit', $muscle) }}">
                    <img class="octicon" src="{{ Vite::asset('resources/imgs/edit.svg') }}" alt="">
                </a>
            </div>
        @endcan
    </div>
    @if($muscle->group()->exists())
        <div class="d-flex">
            <span class="mr-1 mt-2">Group:</span>
            @can('view', $muscle->group)
                <a href="{{ route('admin.group.show', $muscle->group) }}" class="text-decoration-none group-link">
                    @endcan
                    <span class="Label mr-1 mt-2 Label--secondary group-name">{{ $muscle->group->name }}</span>
                    @can('view', $muscle->group)
                </a>
            @endcan
        </div>
    @endif
    @if($active_exercises->count() > 0)
        <div class="d-flex">
            <span class="mr-1 mt-2">Exercises:</span>
            <div class="text-small color-fg-subtle">
                @foreach($active_exercises as $exerciseIndex=>$exercise)
                    @can('view', $exercise)
                        <a
                            href="{{ route('admin.exercise.show', $exercise) }}"
                            class="text-decoration-none exercise-{{ $exerciseIndex }}-link"
                        >
                    @endcan
                        @if ($exercise->pivot->intensity == 1.0)
                            <span
                    class="Label mr-1 mt-2 Label--success text-decoration-none exercise-{{ $exerciseIndex }}-name-10"
                            >
                                {{ $exercise->name }}
                            </span>
                        @elseif($exercise->pivot->intensity === 0.5)
                            <span
                    class="Label mr-1 mt-2 Label--accent text-decoration-none exercise-{{ $exerciseIndex }}-name-05"
                            >
                                {{ $exercise->name }}
                            </span>
                        @else
                            <span
                    class="Label mr-1 mt-2 Label--danger text-decoration-none exercise-{{ $exerciseIndex }}-name-025"
                            >
                            {{ $exercise->name }}
                            </span>
                        @endif
                    @can('view', $exercise)
                        </a>
                    @endcan
                @endforeach
            </div>
        </div>
    @endif
    <div class="d-flex mt-2">
        <span class="mr-1">Heavy:</span>
        <span class="mr-1">min:
            <span class="heavy-min">
                {{ $muscle->heavy_min }}
            </span>
        </span>
        <span class="mr-1">max:
            <span class="heavy-max">
                {{ $muscle->heavy_max }}
            </span>
        </span>
    </div>
    <div class="d-flex mt-2">
        <span class="mr-1">Light:</span>
        <span class="mr-1">min:
            <span class="light-min">
                {{ $muscle->light_min }}
            </span>
        </span>
        <span class="mr-1">max:
            <span class="light-max">
                {{ $muscle->light_max }}
            </span>
        </span>
    </div>
    <div class="d-flex mt-2">
        <span class="mr-1">Max:
            <span class="max">
                {{ $muscle->max }}
            </span>
        </span>
    </div>
    <div class="d-flex mt-2">
        <span class="mr-1">Fiber type:</span>
        <span class="fiber-type">{{ $muscle->fiber_type }}</span>
    </div>
@endsection
