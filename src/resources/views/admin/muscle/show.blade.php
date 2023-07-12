@extends('admin.layouts.admin')

@section('content')
    <div class="Box rounded-top-0">
        <div class="blankslate">
            <h3 class="blankslate-heading">{{ $muscle->name }}</h3>
            <div class="d-flex flex-justify-center flex-items-center">
                <span class="mr-1 mt-2">Group:</span>
                <a href="{{ route('admin.group.show', $muscle->group) }}">
                    <span class="Label mr-1 mt-2 Label--secondary">{{ $muscle->group->name }}</span>
                </a>
            </div>
            <div class="d-flex flex-justify-center flex-items-center">
                <span class="mr-1 mt-2">Exercises:</span>
                <div class="text-small color-fg-subtle">
                    @foreach($active_exercises as $exercise)
                        <a href="{{ route('admin.exercise.show', $exercise) }}">
                            @if ($exercise->pivot->intensity == 1)
                                <span class="Label mr-1 mt-2 Label--success">{{ $exercise->name }}</span>
                            @elseif($exercise->pivot->intensity === 0.5)
                                <span class="Label mr-1 mt-2 Label--accent">{{ $exercise->name }}</span>
                            @else
                                <span class="Label mr-1 mt-2 Label--danger">{{ $exercise->name }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="blankslate-action">
                <a class="btn btn-primary" href="{{ route('admin.muscle.edit', $muscle) }}" type="button">Edit</a>
            </div>
            <div class="blankslate-action">
                <a class="btn-link" type="button" href="{{ route('admin.muscle.index') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
