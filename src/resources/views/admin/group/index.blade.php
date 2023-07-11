@php use App\Models\Group; @endphp

@extends('admin.layouts.admin')

@section('content')
    <div class="Box Box--condensed">
        <div class="Box-header d-flex flex-items-center">
            <h3 class="Box-title overflow-hidden flex-auto">
                Muscle Groups
                <span class="Counter Counter--gray-dark">{{ count($groups) }}</span>
            </h3>
            @can('create', Group::class)
            <a class="btn btn-primary btn-sm" href="{{ route('admin.group.create') }}">
                <img class="octicon" src="{{ Vite::asset('resources/imgs/add.svg') }}" alt="">
            </a>
            @endcan
        </div>
        @foreach($groups as $group)
            <div class="Box-row d-flex flex-items-center">
                <div class="flex-auto">
                    <a href="{{ route('admin.group.show', $group) }}" class="Link Link--primary">
                        <strong>{{ $group->name }}</strong>
                    </a>
                    <div class="text-small color-fg-subtle">
                        @foreach($group->muscles as $muscle)
                            <a href="{{ route('admin.muscle.show', $muscle) }}">
                                <span class="Label mr-1 mt-2 Label--secondary">{{ $muscle->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex flex-justify-end">
                    @can('view', $group)
                    <a href="{{ route('admin.group.show', $group) }}">
                        <button type="button" class="btn btn-primary" name="button">
                            <img class="octicon" src="{{ Vite::asset('resources/imgs/view.svg') }}" alt="">
                        </button>
                    </a>
                    @endcan
                    @can('update', $group)
                    <a class="ml-2" href="{{ route('admin.group.edit', $group) }}">
                        <button type="button" class="btn btn-secondary" name="button">
                            <img class="octicon" src="{{ Vite::asset('resources/imgs/edit.svg') }}" alt="">
                        </button>
                    </a>
                    @endcan
                    @can('delete', $group)
                    <form method="post" action="{{ route('admin.group.destroy', $group) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger ml-2" href="{{ route('admin.group.destroy', $group) }}">
                            <img class="octicon octicon-pencil" src="{{ Vite::asset('resources/imgs/delete.svg') }}" alt="">
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
@endsection
