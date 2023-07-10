@extends('admin.layouts.admin')

@section('content')
    <div class="Box">
        <div class="Box-header">
            <h3 class="Box-title">
                {{ $muscle->name }}
            </h3>
        </div>
        <form method="post" action="{{ route('admin.muscle.update', $muscle) }}">
            @csrf
            @method('put')
            <div class="Box-body">
                <div class="form-group @error('name') errored @enderror">
                    <div class="form-group-header">
                        <label for="name-input">Name</label>
                    </div>
                    <div class="form-group-body">
                        <input
                            class="form-control"
                            type="text"
                            value="{{ old('name', $muscle->name) }}"
                            id="name-input"
                            name="name"
                            aria-describedby="name-input-validation"
                        />
                    </div>
                    @error('name')
                    <p class="note error" id="name-input-validation">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group @error('name') errored @enderror">
                    <div class="form-group-header">
                        <label for="name-input">Name</label>
                    </div>
                    <div class="form-group-body">
                        <select class="form-select" aria-label="Muscle group" name="group_id">
                            <option>Muscle group</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" @selected(old('group_id', $muscle->group_id) == $group->id)>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('name')
                    <p class="note error" id="name-input-validation">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="Box-footer text-right">
                <a href="{{ route('admin.muscle.index') }}" class="btn btn-secondary mr-1">
                    Back
                </a>
                <button class="btn btn-primary" type="submit">
                    Save
                </button>
            </div>
        </form>
    </div>
@endsection
