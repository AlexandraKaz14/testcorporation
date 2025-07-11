<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateTestRequest extends FormRequest
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
            'picture' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'nullable|string',
            'categories' => 'required|array|max:6|exists:categories,id',
            'tags' => 'required|array|max:10',
            'tags.*' => 'string',
            'user_id' => 'required|int|exists:users,id',
            'slug' => [
                'required',
                'string',
                'regex:/^[a-z0-9\-]+$/',
                'max:70',
                'unique:tests,slug',
            ],
            'theme_id' => 'nullable|int|exists:themes,id',
            'background_image' => 'nullable|mimes:jpg,jpeg,png,webp',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
            'slug' => $this->slug ? Str::slug($this->slug) : Str::slug((string) $this->title),
            'title' => mb_strtoupper(mb_substr((string) $this->title, 0, 1)) . mb_substr((string) $this->title, 1),
        ]);
    }
}
