@extends('admin.layouts.admin')

@section('content')
    <div class="Box rounded-top-0">
        <div class="blankslate">
            <h3 class="blankslate-heading">{{ $group->name }}</h3>
            <div class="text-small color-fg-subtle">
                @foreach($group->muscles as $muscle)
                    <a href="{{ route('admin.muscle.show', $muscle) }}">
                        <span class="Label mr-1 mt-2 Label--secondary">{{ $muscle->name }}</span>
                    </a>
                @endforeach
            </div>
            <div class="blankslate-action">
                <a class="btn btn-primary" href="{{ route('admin.group.edit', $group) }}" type="button">Edit</a>
            </div>
            <div class="blankslate-action">
                <a class="btn-link" type="button" href="{{ route('admin.group.index') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
