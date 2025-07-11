<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answer_id' => 'required|int|exists:answers,id',
            'variable_id' =>
                [
                    'required',
                    'int',
                    'exists:variables,id',
                    Rule::unique('reactions')->where(function ($query) {
                        return $query->where('answer_id', $this->answer_id);
                    })->ignore($this->route('reaction')->id),
                ],
            'value' => 'required|numeric|min:0.0',
            'operation' => 'required|string',
        ];
    }
}
