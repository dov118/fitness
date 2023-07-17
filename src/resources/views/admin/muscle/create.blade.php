@extends('admin.layouts.admin')

@section('content')
    <form method="post" action="{{ route('admin.muscle.store') }}" class="muscle-create-form">
        @csrf
        @method('post')
        <div class="Subhead">
            <h2 class="Subhead-heading">Create muscle</h2>
        </div>
        <div class="form-group name-form @error('name') errored @enderror">
            <div class="form-group-header">
                <label for="name-input">Name</label>
            </div>
            <div class="form-group-body">
                <input
                    class="form-control name-input"
                    type="text"
                    value="{{ old('name', '') }}"
                    id="name-input"
                    name="name"
                    aria-describedby="name-input-validation"
                />
            </div>
            @error('name')
            <p class="note error name-error" id="name-input-validation">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group fiber_type-form @error('fiber_type') errored @enderror">
            <div class="form-group-header">
                <label for="fiber_type-input">Fiber type</label>
            </div>
            <div class="form-group-body">
                <textarea class="form-control fiber_type-input" id="fiber_type-input" name="fiber_type">
                    {{ old('fiber_type', '') }}
                </textarea>
            </div>
            @error('fiber_type')
            <p class="note error fiber_type-error" id="fiber_type-input-validation">{{ $message }}</p>
            @enderror
        </div>

        <div class="Subhead">
            <h2 class="Subhead-heading">Muscle group</h2>
        </div>

        <div class="form-group group_id-form @error('group_id') errored @enderror">
            <div class="form-group-header">
                <label for="name-input">Muscle group</label>
            </div>
            <div class="form-group-body">
                <select class="form-select group_id-input" aria-label="Muscle group" name="group_id">
                    <option value="null">Muscle group</option>
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}" @selected(old('group_id', '') == $group->id)>
                            {{ $group->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('group_id')
            <p class="note error group_id-error" id="name-input-validation">{{ $message }}</p>
            @enderror
        </div>

        <div class="Subhead">
            <h2 class="Subhead-heading">Repetition range</h2>
        </div>

        <div class="d-flex">
            <div class="form-group heavy_min-form @error('heavy_min') errored @enderror">
                <div class="form-group-header">
                    <label for="heavy_min-input">Min heavy repetitions</label>
                </div>
                <div class="form-group-body">
                    <input
                        class="form-control heavy_min-input"
                        type="number"
                        value="{{ old('heavy_min', '') }}"
                        id="heavy_min-input"
                        name="heavy_min"
                        aria-describedby="heavy_min-input-validation"
                    />
                </div>
                @error('heavy_min')
                <p class="note error heavy_min-error" id="heavy_min-input-validation">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group heavy_max-form @error('heavy_max') errored @enderror">
                <div class="form-group-header">
                    <label for="heavy_max-input">Max heavy repetitions</label>
                </div>
                <div class="form-group-body">
                    <input
                        class="form-control heavy_max-input"
                        type="number"
                        value="{{ old('heavy_max', '') }}"
                        id="heavy_max-input"
                        name="heavy_max"
                        aria-describedby="heavy_max-input-validation"
                    />
                </div>
                @error('heavy_max')
                <p class="note error heavy_max-error" id="heavy_max-input-validation">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="d-flex">
            <div class="form-group light_min-form @error('light_min') errored @enderror">
                <div class="form-group-header">
                    <label for="light_min-input">Min light repetitions</label>
                </div>
                <div class="form-group-body">
                    <input
                        class="form-control light_min-input"
                        type="number"
                        value="{{ old('light_min', '') }}"
                        id="light_min-input"
                        name="light_min"
                        aria-describedby="light_min-input-validation"
                    />
                </div>
                @error('light_min')
                <p class="note error light_min-error" id="light_min-input-validation">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group light_max-form @error('light_max') errored @enderror">
                <div class="form-group-header">
                    <label for="light_max-input">Max light repetitions</label>
                </div>
                <div class="form-group-body">
                    <input
                        class="form-control light_max-input"
                        type="number"
                        value="{{ old('light_max', '') }}"
                        id="light_max-input"
                        name="light_max"
                        aria-describedby="light_max-input-validation"
                    />
                </div>
                @error('light_max')
                <p class="note error light_max-error" id="light_max-input-validation">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group max-form @error('max') errored @enderror">
            <div class="form-group-header">
                <label for="max-input">Max repetitions</label>
            </div>
            <div class="form-group-body">
                <input
                    class="form-control max-input"
                    type="number"
                    value="{{ old('max', '') }}"
                    id="max-input"
                    name="max"
                    aria-describedby="max-input-validation"
                />
            </div>
            @error('max')
            <p class="note error max-error" id="max-input-validation">{{ $message }}</p>
            @enderror
        </div>

        <div class="Subhead">
            <h2 class="Subhead-heading">Exercises</h2>
        </div>

        @foreach ($exercises as $exercise)
            <div class="form-group">
                <div class="form-group-header">
                    <label for="option-{{ $exercise->id }}">{{ $exercise->name }}</label>
                </div>
                <div class="form-group-body">
                    <div class="radio-group">
                        <input
                            checked
                            class="radio-input"
                            id="option-a-{{ $exercise->id }}"
                            type="radio"
                            name="option-{{ $exercise->id }}"
                            value="0.0"
                        >
                        <label class="radio-label Label--muted" for="option-a-{{ $exercise->id }}">
                            0%
                        </label>
                        <input
                            class="radio-input"
                            id="option-b-{{ $exercise->id }}"
                            type="radio"
                            name="option-{{ $exercise->id }}"
                            value="0.25"
                        >
                        <label class="radio-label Label--danger" for="option-b-{{ $exercise->id }}">
                            25%
                        </label>
                        <input
                            class="radio-input"
                            id="option-c-{{ $exercise->id }}"
                            type="radio"
                            name="option-{{ $exercise->id }}"
                            value="0.5"
                        >
                        <label class="radio-label Label--accent" for="option-c-{{ $exercise->id }}">
                            50%
                        </label>
                        <input
                            class="radio-input"
                            id="option-d-{{ $exercise->id }}"
                            type="radio"
                            name="option-{{ $exercise->id }}"
                            value="1.0"
                        >
                        <label class="radio-label Label--success" for="option-d-{{ $exercise->id }}">
                            100%
                        </label>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="text-center">
            <button class="btn btn-primary save-button" type="submit">
                Save
            </button>
        </div>
    </form>
@endsection
