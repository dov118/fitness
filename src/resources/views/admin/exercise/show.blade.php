@extends('admin.layouts.admin')

@section('content')
    <div class="Box rounded-top-0">
        <div class="blankslate">
            <h3 class="blankslate-heading">{{ $exercise->name }}</h3>
            @foreach($exercise->files as $file)
                <img src="{{ $file->data }}" alt="" width="500">
            @endforeach
            <div class="blankslate-action">
                <a class="btn btn-primary" href="{{ route('admin.exercise.edit', $exercise) }}" type="button">Edit</a>
            </div>
            <div class="blankslate-action">
                <a class="btn-link" type="button" href="{{ route('admin.exercise.index') }}">Back</a>
            </div>
        </div>
    </div>
@endsection
