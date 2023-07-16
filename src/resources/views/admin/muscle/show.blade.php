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
    <div class="d-flex">
        <span class="mr-1 mt-2">Group:</span>
        @can('view', $muscle->group)
            <a href="{{ route('admin.group.show', $muscle->group) }}" class="text-decoration-none">
        @endcan
            <span class="Label mr-1 mt-2 Label--secondary">{{ $muscle->group->name }}</span>
        @can('view', $muscle->group)
            </a>
        @endcan
    </div>
    <div class="d-flex">
        <span class="mr-1 mt-2">Exercises:</span>
        <div class="text-small color-fg-subtle">
            @foreach($active_exercises as $exercise)
                @can('view', $exercise)
                    <a href="{{ route('admin.exercise.show', $exercise) }}" class="text-decoration-none">
                @endcan
                    @if ($exercise->pivot->intensity == 1)
                        <span class="Label mr-1 mt-2 Label--success">{{ $exercise->name }}</span>
                    @elseif($exercise->pivot->intensity === 0.5)
                        <span class="Label mr-1 mt-2 Label--accent">{{ $exercise->name }}</span>
                    @else
                        <span class="Label mr-1 mt-2 Label--danger">{{ $exercise->name }}</span>
                    @endif
                @can('view', $exercise)
                    </a>
                @endcan
            @endforeach
        </div>
    </div>
    <div class="d-flex">
        <span class="mr-1 mt-2">Heavy range:</span>
        <span class="Label mr-1 mt-2 Label--success">{{ $muscle->heavy_min }}</span>
        <span class="Label mr-1 mt-2 Label--danger">{{ $muscle->heavy_max }}</span>
    </div>
    <div class="d-flex">
        <span class="mr-1 mt-2">Light range:</span>
        <span class="Label mr-1 mt-2 Label--success">{{ $muscle->light_min }}</span>
        <span class="Label mr-1 mt-2 Label--danger">{{ $muscle->light_max }}</span>
    </div>
    <div class="d-flex">
        <span class="mr-1 mt-2">Max repetition:</span>
        <span class="Label mr-1 mt-2 Label--danger">{{ $muscle->max }}</span>
    </div>
    <div class="d-flex">
        <span class="mr-1 mt-2">Fiber type:</span>
        <span class="Label mr-1 mt-2 Label--primary">{{ $muscle->fiber_type }}</span>
    </div>
@endsection
