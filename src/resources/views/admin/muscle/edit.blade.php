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
                <div class="Subhead">
                    <h2 class="Subhead-heading">Muscle</h2>
                </div>
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
                <div class="Subhead">
                    <h2 class="Subhead-heading">Group</h2>
                </div>
                <div class="form-group @error('name') errored @enderror">
                    <div class="form-group-header">
                        <label for="name-input">Name</label>
                    </div>
                    <div class="form-group-body">
                        <select class="form-select" aria-label="Muscle group" name="group_id">
                            <option>Muscle group</option>
                            @foreach ($groups as $group)
                                <option
                                    value="{{ $group->id }}"
                                    @selected(old('group_id', $muscle->group_id) == $group->id)
                                >
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('name')
                    <p class="note error" id="name-input-validation">{{ $message }}</p>
                    @enderror
                </div>
                <div class="Subhead">
                    <h2 class="Subhead-heading">Active exercises</h2>
                </div>
                @foreach ($active_exercises as $exercise)
                    <div class="form-group">
                        <div class="form-group-header">
                            <label for="name-input">{{ $exercise->name }}</label>
                        </div>
                        <div class="form-group-body">
                            <div class="radio-group">
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 0.0)
                                    class="radio-input"
                                    id="option-a-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="0.0"
                                >
                                <label class="radio-label Label--muted" for="option-a-{{ $exercise->id }}">0%</label>
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 0.25)
                                    class="radio-input"
                                    id="option-b-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="0.25"
                                >
                                <label class="radio-label Label--danger" for="option-b-{{ $exercise->id }}">25%</label>
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 0.5)
                                    class="radio-input"
                                    id="option-c-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="0.5"
                                >
                                <label class="radio-label Label--accent" for="option-c-{{ $exercise->id }}">50%</label>
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 1.0)
                                    class="radio-input"
                                    id="option-d-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="1.0"
                                >
                                <label class="radio-label Label--success" for="option-d-{{ $exercise->id }}">100%</label>
                            </div>
                        </div>
                        @error('name')
                        <p class="note error" id="name-input-validation">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
                <div class="Subhead">
                    <h2 class="Subhead-heading">Inactive exercises</h2>
                </div>
                @foreach ($inactive_exercises as $exercise)
                    <div class="form-group">
                        <div class="form-group-header">
                            <label for="name-input">{{ $exercise->name }}</label>
                        </div>
                        <div class="form-group-body">
                            <div class="radio-group">
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 0.0)
                                    class="radio-input"
                                    id="option-a-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="0.0"
                                >
                                <label class="radio-label Label--muted" for="option-a-{{ $exercise->id }}">0%</label>
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 0.25)
                                    class="radio-input"
                                    id="option-b-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="0.25"
                                >
                                <label class="radio-label Label--danger" for="option-b-{{ $exercise->id }}">25%</label>
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 0.5)
                                    class="radio-input"
                                    id="option-c-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="0.5"
                                >
                                <label class="radio-label Label--accent" for="option-c-{{ $exercise->id }}">50%</label>
                                <input
                                    @checked($exercise->muscles()->find($muscle->id)->pivot->intensity === 1.0)
                                    class="radio-input"
                                    id="option-d-{{ $exercise->id }}"
                                    type="radio"
                                    name="option-{{ $exercise->id }}"
                                    value="1.0"
                                >
                                <label class="radio-label Label--success" for="option-d-{{ $exercise->id }}">100%</label>
                            </div>
                        </div>
                        @error('name')
                        <p class="note error" id="name-input-validation">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
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
