@php use App\Models\Muscle; @endphp

@extends('admin.layouts.admin')

@section('content')
    <div class="Subhead">
        <h3 class="Subhead-heading content-title">
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
    @foreach($groups as $groupIndex=>$group)
        <div class="Box Box--condensed mb-5">
            <div class="Box-header d-flex flex-items-center">
                <h3 class="Box-title overflow-hidden flex-auto">
                    @can('view', $group)
                        <a
                            href="{{ route('admin.group.show', $group) }}"
                            class="Link Link--primary group-{{ $groupIndex }}-name"
                        >
                            {{ $group->name }}
                        </a>
                    @endcan
                    @cannot('view', $group)
                        <span class="group-{{ $groupIndex }}-name">{{ $group->name }}</span>
                    @endcannot
                    <span class="Counter Counter--gray-dark group-{{ $groupIndex }}-counter">
                        {{ $group->muscles->count() }}
                    </span>
                </h3>
            </div>
            @foreach($group->muscles as $muscleIndex=>$muscle)
                <div class="Box-row d-flex flex-items-center group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}">
                    <div class="flex-auto">
                        @can('view', $muscle)
                            <a
                                href="{{ route('admin.muscle.show', $muscle) }}"
                                class="Link Link--primary group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-link"
                            >
                                <strong class="group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-name">
                                    {{ $muscle->name }}
                                </strong>
                            </a>
                        @endcan
                        @cannot('view', $muscle)
                            <span class="group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-link">
                                <strong class="group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-name">
                                    {{ $muscle->name }}
                                </strong>
                            </span>
                        @endcannot
                        <div class="text-small color-fg-subtle">
                            @foreach($muscle->exercises as $exerciseIndex=>$exercise)
                                @can('view', $exercise)
                                    <a
                                class="group-{{$groupIndex}}-muscle-{{$muscleIndex}}-exercise-{{$exerciseIndex}}-link text-decoration-none"
                                    href="{{ route('admin.exercise.show', $exercise) }}"
                                    >
                                @endcan
                                @cannot('view', $group)
                                    <span
                                class="group-{{$groupIndex}}-muscle-{{$muscleIndex}}-exercise-{{$exerciseIndex}}-link"
                                    >
                                @endcannot
                                    @if ($exercise->pivot->intensity == 1)
                                        <span
                                            class="Label mr-1 mt-2 Label--success
                                      group-{{$groupIndex}}-muscle-{{$muscleIndex}}-exercise-{{$exerciseIndex}}-name--1"
                                        >{{ $exercise->name }}</span>
                                    @elseif($exercise->pivot->intensity === 0.5)
                                        <span
                                            class="Label mr-1 mt-2 Label--accent
                                     group-{{$groupIndex}}-muscle-{{$muscleIndex}}-exercise-{{$exerciseIndex}}-name--05"
                                        >{{ $exercise->name }}</span>
                                    @else
                                        <span
                                            class="Label mr-1 mt-2 Label--danger
                                    group-{{$groupIndex}}-muscle-{{$muscleIndex}}-exercise-{{$exerciseIndex}}-name--025"
                                        >{{ $exercise->name }}</span>
                                    @endif
                                @can('view', $exercise)
                                    </span>
                                @endcan
                                @cannot('view', $exercise)
                                    </a>
                                @endcannot
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex flex-justify-end">
                        @can('view', $muscle)
                        <a
                            class="group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-show-link"
                            href="{{ route('admin.muscle.show', $muscle) }}"
                        >
                            <button type="button" class="btn btn-primary" name="button">
                                <img class="octicon" src="{{ Vite::asset('resources/imgs/view.svg') }}" alt="">
                            </button>
                        </a>
                        @endcan
                        @can('update', $muscle)
                        <a
                            class="ml-2 group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-edit-link"
                            href="{{ route('admin.muscle.edit', $muscle) }}"
                        >
                            <button type="button" class="btn btn-secondary" name="button">
                                <img class="octicon" src="{{ Vite::asset('resources/imgs/edit.svg') }}" alt="">
                            </button>
                        </a>
                        @endcan
                        @can('delete', $muscle)
                            <form method="post" action="{{ route('admin.muscle.destroy', $muscle) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger ml-2
                                group-{{ $groupIndex }}-muscle-{{ $muscleIndex }}-delete-link"
                                        href="{{ route('admin.muscle.destroy', $muscle) }}">
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
