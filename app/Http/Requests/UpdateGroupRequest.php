<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateGroupRequest extends FormRequest
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
            'title' => 'required|string|max:70',
            'description' => 'required|string',
            'picture' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'tests' => 'required|array|max:20|exists:tests,id',
            'slug' => [
                'required',
                'string',
                'regex:/^[a-z0-9\-]+$/',
                'max:70',
                Rule::unique('groups', 'slug')->ignore($this->group),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->slug ? Str::slug($this->slug) : Str::slug($this->title),
        ]);
    }
}
