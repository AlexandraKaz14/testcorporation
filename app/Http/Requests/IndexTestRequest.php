<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Test;
use App\Rules\Daterange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexTestRequest extends FormRequest
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
            'daterange' => ['string', new Daterange()],
            'categories' => 'array',
            'tags' => 'array',
            'tags.*' => 'string|max:256',
            'statuses.*' => [Rule::in(Test::STATUSES)],
            'deletedStatuses' => 'array',
            'deletedStatuses.*' => [Rule::in(Test::DELETED_STATUSES)],
            'startDate' => ['date', 'date_format:Y-m-d'],
            'endDate' => ['date', 'date_format:Y-m-d', 'after_or_equal:' . $this->get('startDate')],
        ];
    }

    protected function prepareForValidation(): void
    {
        $dateRange = request()
            ->get('daterange', '');

        $this->merge([
            'startDate' => explode(' - ', $dateRange)[0] ?: '2024-01-01',
            'endDate' => explode(' - ', $dateRange)[1] ?? now()->format('Y-m-d'),
        ]);
    }
}
