<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCatalogRequest extends FormRequest
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
            'category_id' => 'nullable|integer|exists:categories,id',
            'tag_id' => 'nullable|integer|exists:tags,id',
            'author_id' => 'nullable|integer|exists:users,id',
            'q' => 'nullable|string|max:255',
            'sort_by' => 'nullable|in:popular_all_time,popular_day,popular_week, popular_month, ',
        ];
    }
}
