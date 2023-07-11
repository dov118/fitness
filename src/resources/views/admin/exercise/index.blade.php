@php use App\Models\Exercise; @endphp

@extends('admin.layouts.admin')

@section('content')
    <div class="Box Box--condensed">
        <div class="Box-header d-flex flex-items-center">
            <h3 class="Box-title overflow-hidden flex-auto">
                Muscles
                <span class="Counter Counter--gray-dark">{{ count($exercises) }}</span>
                <span class="Label ml-6 mr-1 mt-2 Label--success">100%</span>
                <span class="Label mr-1 mt-2 Label--accent">50%</span>
                <span class="Label mr-1 mt-2 Label--danger">25%</span>
            </h3>
            @can('create', Exercise::class)
            <a class="btn btn-primary btn-sm" href="{{ route('admin.exercise.create') }}">
                <img class="octicon" src="{{ Vite::asset('resources/imgs/add.svg') }}" alt="">
            </a>
            @endcan
        </div>
        @foreach($exercises as $exercise)
            <div class="Box-row d-flex flex-items-center">
                <a
                    href="{{ route('admin.exercise.show', $exercise) }}"
                    class="d-flex flex-justify-start flex-items-center"
                >
                    @foreach($exercise->files as $file)
                        <img src="{{ $file->data }}" alt="" width="200" class="mr-4">
                    @endforeach
                </a>
                <div class="flex-auto">
                    <a href="{{ route('admin.exercise.show', $exercise) }}" class="Link Link--primary">
                        <strong>{{ $exercise->name }}</strong>
                    </a>
                    <div class="text-small color-fg-subtle">
                        @foreach($exercise->muscles as $muscle)
                            <a href="{{ route('admin.muscle.show', $muscle) }}">
                                @if ($muscle->pivot->intensity == 1)
                                    <span class="Label mr-1 mt-2 Label--success">{{ $muscle->name }}</span>
                                @elseif($muscle->pivot->intensity === 0.5)
                                    <span class="Label mr-1 mt-2 Label--accent">{{ $muscle->name }}</span>
                                @else
                                    <span class="Label mr-1 mt-2 Label--danger">{{ $muscle->name }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex flex-justify-end">
                    @can('view', $exercise)
                    <a href="{{ route('admin.exercise.show', $exercise) }}">
                        <button type="button" class="btn btn-primary" name="button">
                            <img class="octicon" src="{{ Vite::asset('resources/imgs/view.svg') }}" alt="">
                        </button>
                    </a>
                    @endcan
                    @can('update', $exercise)
                    <a class="ml-2" href="{{ route('admin.exercise.edit', $exercise) }}">
                        <button type="button" class="btn btn-secondary" name="button">
                            <img class="octicon" src="{{ Vite::asset('resources/imgs/edit.svg') }}" alt="">
                        </button>
                    </a>
                    @endcan
                    @can('delete', $exercise)
                    <form method="post" action="{{ route('admin.exercise.destroy', $exercise) }}">
                        @csrf
                        @method('delete')
                        <button
                            href="{{ route('admin.exercise.destroy', $exercise) }}"
                            type="button"
                            class="btn btn-danger ml-2"
                            name="button"
                        >
                            <img class="octicon" src="{{ Vite::asset('resources/imgs/delete.svg') }}" alt="">
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
@endsection
