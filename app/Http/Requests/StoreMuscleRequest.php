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
        return array_filter([
            'name' => $this->nameRules(),
            'group_id' => $this->groupIdRules(),
            'heavy_min' => $this->heavyMinRules(),
            'heavy_max' => $this->heavyMaxRules(),
            'light_min' => $this->lightMinRules(),
            'light_max' => $this->lightMaxRules(),
            'max' => $this->maxRules(),
            'fiber_type' => $this->fiberTypeRules(),
        ], fn ($rules) => $rules !== []);
    }

    protected function nameRules(): array
    {
        return [
            'required',
            'max:64',
            'string',
            Rule::unique('muscles', 'name')
        ];
    }

    protected function groupIdRules(): array
    {
        if (!$this->get('group_id') || $this->get('group_id') === "null") {
            return [];
        }

        return [
            'integer',
            'exists:App\Models\Group,id'
        ];
    }

    protected function heavyMinRules(): array
    {
        if ((!(int)$this->get('heavy_min') && $this->get('heavy_min') !== "0") ||
            (!$this->get('heavy_min') && $this->get('heavy_min') !== "0")
        ) {
            return [];
        }

        $rules = ['required_with:heavy_max', 'integer', 'min:1'];

        if ((int)$this->get('heavy_max')) {
            $rules[] = 'max:' . $this->get('heavy_max');
        }

        return $rules;
    }

    protected function heavyMaxRules(): array
    {
        if (!$this->get('heavy_max') && !$this->get('heavy_min')) {
            return [];
        }

        $rules = ['required_with:heavy_min', 'integer'];

        if (is_integer($this->get('heavy_min'))) {
            $rules[] = 'min:' . $this->get('heavy_min');
        }

        if (is_integer($this->get('max'))) {
            $rules[] = 'max:' . $this->get('max');
        }

        return $rules;
    }

    protected function lightMinRules(): array
    {
        if ((!(int)$this->get('light_min') && $this->get('light_min') !== "0") ||
            (!$this->get('light_min') && $this->get('light_min') !== "0")
        ) {
            return [];
        }

        $rules = ['required_with:light_max', 'integer', 'min:1'];

        if ((int)$this->get('light_max')) {
            $rules[] = 'max:' . $this->get('light_max');
        }

        return $rules;
    }

    protected function lightMaxRules(): array
    {
        if (!$this->get('light_max')) {
            return [];
        }

        $rules = ['required', 'integer'];

        if (is_integer($this->get('light_min'))) {
            $rules[] = 'min:' . $this->get('light_min');
        }

        if (is_integer($this->get('max'))) {
            $rules[] = 'max:' . $this->get('max');
        }

        return $rules;
    }

    protected function maxRules(): array
    {
        if (!$this->get('max')) {
            return [];
        }

        return [
            'integer',
            'min:' . max([
                $this->get('light_max', 0) ?? 0,
                $this->get('heavy_max', 0) ?? 0,
            ]),
        ];
    }

    protected function fiberTypeRules(): array
    {
        if (!$this->get('fiber_type')) {
            return [];
        }

        return [
            'string',
            'max:255'
        ];
    }
}
