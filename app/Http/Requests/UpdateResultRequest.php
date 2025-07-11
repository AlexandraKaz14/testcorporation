<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ConditionalExpression;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResultRequest extends FormRequest
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
            'text' => 'nullable|string',
            'picture' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'test_id' => 'required|int|exists:tests,id',
            'condition' => ['required', 'string', new ConditionalExpression()],
        ];
    }

    protected function prepareForValidation()
    {
        $result = $this->route('result');

        if ($result && $result->is_default) {
            $this->merge([
                'condition' => $result->condition,
            ]);
        }
    }
}
