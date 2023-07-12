<?php

namespace App\Http\Requests;

use App\Models\Muscle;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreMuscleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Muscle $muscle): bool
    {
        return Auth::user()->can('create', $muscle);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:64', Rule::unique('muscles', 'name')],
            'group_id' => ['required', 'Integer', 'exists:App\Models\Group,id'],
        ];
    }
}
