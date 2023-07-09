@extends('admin.layouts.admin')

@section('content')
    <div class="Box rounded-top-0">
        <div class="blankslate">
            <h3 class="blankslate-heading">{{ $muscle->name }}</h3>
            <a href="{{ route('admin.group.show', $muscle->group) }}"><span class="Label mr-1 mt-2 Label--secondary">{{ $muscle->group->name }}</span></a>
            <div class="blankslate-action">
                <a class="btn btn-primary" href="{{ route('admin.muscle.edit', $muscle) }}" type="button">Edit</a>
            </div>
            <div class="blankslate-action">
                <a class="btn-link" type="button" href="{{ route('admin.muscle.index') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
