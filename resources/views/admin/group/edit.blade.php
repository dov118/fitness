@extends('admin.layouts.admin')

@section('content')
    <div class="Box">
        <div class="Box-header">
            <h3 class="Box-title">
                {{ $group->name }}
            </h3>
        </div>
        <form method="post" action="{{ route('admin.group.update', $group) }}">
            @csrf
            @method('put')
            <div class="Box-body">
                <div class="Subhead">
                    <h2 class="Subhead-heading">Group</h2>
                </div>
                <div class="form-group @error('name') errored @enderror">
                    <div class="form-group-header">
                        <label for="name-input">Name</label>
                    </div>
                    <div class="form-group-body">
                        <input
                            class="form-control"
                            type="text"
                            value="{{ old('name', $group->name) }}"
                            id="name-input"
                            name="name"
                            aria-describedby="name-input-validation"
                        />
                    </div>
                    @error('name')
                    <p class="note error" id="name-input-validation">{{ $message }}</p>
                    @enderror
                </div>
                <div class="Subhead">
                    <h2 class="Subhead-heading">Muscles</h2>
                </div>
                @foreach ($muscles as $muscle)
                    <div class="form-checkbox">
                        <label>
                            <input
                                type="checkbox"
                                @checked($group->muscles->contains($muscle))
                                name="muscle_{{ $muscle->id }}"
                            />
                            {{ $muscle->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="Box-footer text-right">
                <a href="{{ route('admin.group.index') }}" class="btn btn-secondary mr-1">
                    Back
                </a>
                <button class="btn btn-primary" type="submit">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection
