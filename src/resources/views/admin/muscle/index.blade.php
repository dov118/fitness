@php use App\Models\Muscle; @endphp

@extends('admin.layouts.admin')

@section('content')
    <div class="Subhead">
        <h3 class="Subhead-heading">
            Muscles
            <span class="Counter Counter--gray-dark v-align-middle title-counter">{{ $muscles->count() }}</span>
        </h3>
        <div class="Subhead-description">
            Intensities:
            <span class="Label mr-1 mt-2 Label--success">100%</span>
            <span class="Label mr-1 mt-2 Label--accent">50%</span>
            <span class="Label mr-1 mt-2 Label--danger">25%</span>
        </div>
        @can('create', Muscle::class)
            <div class="Subhead-actions">
                <a class="btn btn-primary btn-sm title-add" href="{{ route('admin.muscle.create') }}">
                    <img class="octicon" src="{{ Vite::asset('resources/imgs/add.svg') }}" alt="">
                </a>
            </div>
        @endcan
    </div>
    @foreach($groups as $index=>$group)
        <div class="Box Box--condensed mb-5">
            <div class="Box-header d-flex flex-items-center">
                <h3 class="Box-title overflow-hidden flex-auto">
                    <a
                        href="{{ route('admin.group.show', $group) }}"
                        class="Link Link--primary group-name--{{ $index }}"
                    >{{ $group->name }}</a>
                    <span class="Counter Counter--gray-dark group-counter--{{ $index }}">
                        {{ $group->muscles->count() }}
                    </span>
                </h3>
            </div>
            @foreach($group->muscles as $muscle)
                <div class="Box-row d-flex flex-items-center">
                    <div class="flex-auto">
                        <a href="{{ route('admin.muscle.show', $muscle) }}" class="Link Link--primary">
                            <strong>{{ $muscle->name }}</strong>
                        </a>
                        <div class="text-small color-fg-subtle">
                            @foreach($muscle->exercises as $exercise)
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
                    <div class="d-flex flex-justify-end">
                        @can('view', $muscle)
                        <a href="{{ route('admin.muscle.show', $muscle) }}">
                            <button type="button" class="btn btn-primary" name="button">
                                <img class="octicon" src="{{ Vite::asset('resources/imgs/view.svg') }}" alt="">
                            </button>
                        </a>
                        @endcan
                        @can('update', $muscle)
                        <a class="ml-2" href="{{ route('admin.muscle.edit', $muscle) }}">
                            <button type="button" class="btn btn-secondary" name="button">
                                <img class="octicon" src="{{ Vite::asset('resources/imgs/edit.svg') }}" alt="">
                            </button>
                        </a>
                            @endcan
                        @can('delete', $muscle)
                        <form method="post" action="{{ route('admin.muscle.destroy', $muscle) }}">
                            @csrf
                            @method('delete')
                            <button
                                href="{{ route('admin.muscle.destroy', $muscle) }}"
                                type="button"
                                class="btn btn-danger ml-2"
                                name="button"
                            >
                                <img
                                    class="octicon octicon-pencil"
                                    src="{{ Vite::asset('resources/imgs/delete.svg') }}"
                                    alt=""
                                >
                            </button>
                        </form>
                            @endcan
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
