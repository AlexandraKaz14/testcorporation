<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateTestRequest extends FormRequest
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
            'picture' => 'mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|string',
            'categories' => 'required|array|max:5|exists:categories,id',
            'tags' => 'required|array|max:10',
            'tags.*' => 'string',
            'slug' => [
                'required',
                'string',
                'regex:/^[a-z0-9\-]+$/',
                'max:70',
                Rule::unique('tests', 'slug')->ignore($this->test),
            ],
            'theme_id' => 'nullable|int|exists:themes,id',
            'background_image' => 'nullable|mimes:jpg,jpeg,png,webp',
            'delete_background_image' => 'nullable|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->slug ? Str::slug($this->slug) : Str::slug($this->title),
        ]);
    }
}
