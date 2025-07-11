<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Test;
use Illuminate\Foundation\Http\FormRequest;

class FinishAnswersRequest extends FormRequest
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
            'answers' => 'required|array',
            'answers.*' => 'int|exists:answers,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $test = $this->route('test');
            $test = Test::query()->findOrFail($test);

            $answerIds = collect($this->input('answers'));

            $validAnswerIds = $test->questions()
                ->with('answers')
                ->get()
                ->pluck('answers.*.id')
                ->flatten();

            if ($answerIds->diff($validAnswerIds)->isNotEmpty()) {
                $validator->errors()
                    ->add('answers', 'Некоторые ответы не принадлежат вопросам данного теста.');
            }

            $questionCount = $test->questions()
                ->count();

            if ($answerIds->count() !== $questionCount) {
                $validator->errors()
                    ->add('answers', 'Количество ответов не совпадает с количеством вопросов теста.');
            }

            $answeredQuestionIds = $test->questions()
                ->whereHas('answers', function ($query) use ($answerIds) {
                    $query->whereIn('id', $answerIds);
                })
                ->pluck('id');

            if ($answeredQuestionIds->unique()->count() !== $questionCount) {
                $validator->errors()
                    ->add('answers', 'На каждый вопрос теста должен быть дан ровно один ответ.');
            }
        });
    }
}
