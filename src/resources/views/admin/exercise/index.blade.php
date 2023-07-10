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
                <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path d="M7.75 2a.75.75 0 0 1 .75.75V7h4.25a.75.75 0 0 1 0 1.5H8.5v4.25a.75.75 0 0 1-1.5 0V8.5H2.75a.75.75 0 0 1 0-1.5H7V2.75A.75.75 0 0 1 7.75 2Z"></path></svg>
            </a>
            @endcan
        </div>
        @foreach($exercises as $exercise)
            <div class="Box-row d-flex flex-items-center">
                <a href="{{ route('admin.exercise.show', $exercise) }}" class="d-flex flex-justify-start flex-items-center">
                    @foreach($exercise->files as $file)
                        <img src="{{ $file->data }}" alt="" width="200" class="mr-4">
                    @endforeach
                </a>
                <div class="flex-auto">
                    <a href="{{ route('admin.exercise.show', $exercise) }}" class="Link Link--primary"><strong>{{ $exercise->name }}</strong></a>
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
                            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M1.679 7.932c.412-.621 1.242-1.75 2.366-2.717C5.175 4.242 6.527 3.5 8 3.5c1.473 0 2.824.742 3.955 1.715 1.124.967 1.954 2.096 2.366 2.717a.119.119 0 010 .136c-.412.621-1.242 1.75-2.366 2.717C10.825 11.758 9.473 12.5 8 12.5c-1.473 0-2.824-.742-3.955-1.715C2.92 9.818 2.09 8.69 1.679 8.068a.119.119 0 010-.136zM8 2c-1.981 0-3.67.992-4.933 2.078C1.797 5.169.88 6.423.43 7.1a1.619 1.619 0 000 1.798c.45.678 1.367 1.932 2.637 3.024C4.329 13.008 6.019 14 8 14c1.981 0 3.67-.992 4.933-2.078 1.27-1.091 2.187-2.345 2.637-3.023a1.619 1.619 0 000-1.798c-.45-.678-1.367-1.932-2.637-3.023C11.671 2.992 9.981 2 8 2zm0 8a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                        </button>
                    </a>
                    @endcan
                    @can('update', $exercise)
                    <a class="ml-2" href="{{ route('admin.exercise.edit', $exercise) }}">
                        <button type="button" class="btn btn-secondary" name="button">
                            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M11.013 1.427a1.75 1.75 0 012.474 0l1.086 1.086a1.75 1.75 0 010 2.474l-8.61 8.61c-.21.21-.47.364-.756.445l-3.251.93a.75.75 0 01-.927-.928l.929-3.25a1.75 1.75 0 01.445-.758l8.61-8.61zm1.414 1.06a.25.25 0 00-.354 0L10.811 3.75l1.439 1.44 1.263-1.263a.25.25 0 000-.354l-1.086-1.086zM11.189 6.25L9.75 4.81l-6.286 6.287a.25.25 0 00-.064.108l-.558 1.953 1.953-.558a.249.249 0 00.108-.064l6.286-6.286z"></path></svg>
                        </button>
                    </a>
                    @endcan
                    @can('delete', $exercise)
                    <form method="post" action="{{ route('admin.exercise.destroy', $exercise) }}">
                        @csrf
                        @method('delete')
                        <button href="{{ route('admin.exercise.destroy', $exercise) }}" type="button" class="btn btn-danger ml-2" name="button">
                            <svg class="octicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"><path fill-rule="evenodd" d="M6.5 1.75a.25.25 0 01.25-.25h2.5a.25.25 0 01.25.25V3h-3V1.75zm4.5 0V3h2.25a.75.75 0 010 1.5H2.75a.75.75 0 010-1.5H5V1.75C5 .784 5.784 0 6.75 0h2.5C10.216 0 11 .784 11 1.75zM4.496 6.675a.75.75 0 10-1.492.15l.66 6.6A1.75 1.75 0 005.405 15h5.19c.9 0 1.652-.681 1.741-1.576l.66-6.6a.75.75 0 00-1.492-.149l-.66 6.6a.25.25 0 01-.249.225h-5.19a.25.25 0 01-.249-.225l-.66-6.6z"></path></svg>
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
@endsection