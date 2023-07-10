<?php

namespace App\Http\Requests;

use App\Models\Exercise;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreExerciseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Exercise $exercise): bool
    {
        return Auth::user()->can('create', $exercise);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:64', Rule::unique(app(Exercise::class)->getTable(), 'name')],
            'guideline' => ['max:4294967295', 'string'],
            'heavy_min' => ['integer'],
            'heavy_max' => ['integer'],
            'light_min' => ['integer'],
            'light_max' => ['integer'],
            'duration' => ['numeric'],
        ];
    }
}
