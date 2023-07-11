@php use App\Models\Muscle; @endphp

@extends('admin.layouts.admin')

@section('content')
    <div class="Box Box--condensed">
        <div class="Box-header d-flex flex-items-center">
            <h3 class="Box-title overflow-hidden flex-auto">
                Muscles
                <span class="Counter Counter--gray-dark">{{ count($muscles) }}</span>
            </h3>
            @can('create', Muscle::class)
            <a class="btn btn-primary btn-sm" href="{{ route('admin.muscle.create') }}">
                <img class="octicon" src="{{ Vite::asset('resources/imgs/add.svg') }}" alt="">
            </a>
            @endcan
        </div>
        @foreach($muscles as $muscle)
            <div class="Box-row d-flex flex-items-center">
                <div class="flex-auto">
                    <a href="{{ route('admin.muscle.show', $muscle) }}" class="Link Link--primary">
                        <strong>{{ $muscle->name }}</strong>
                    </a>
                    <div class="text-small color-fg-subtle">
                        <a href="{{ route('admin.group.show', $muscle->group) }}">
                            <span class="Label mr-1 mt-2 Label--secondary">{{ $muscle->group->name }}</span>
                        </a>
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
@endsection
