<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Http\Requests\UpdateQuestionSequenceRequest;
use App\Models\Question;
use App\Models\Test;
use App\Services\QuestionManager;

class QuestionController extends Controller
{
    public function create()
    {
        $question = $this->prepareQuestion();

        $this->authorize('viewOrCreate', $question);

        return view('admin.questions.create', compact('question'));
    }

    public function store(QuestionManager $questionManager, CreateQuestionRequest $request)
    {
        $question = $this->prepareQuestion();

        $this->authorize('storeOrUpdateOrDelete', $question);

        $question = $questionManager->upsertQuestion(new Question(), $request->validated());

        return redirect()
            ->route(auth()->user()->role . '.tests.show', $question->test_id)
            ->withSuccess('Вопрос создан');
    }

    public function show(Question $question, QuestionManager $questionManager)
    {
        $this->authorize('viewOrCreate', $question);
        $answersDeleted = filter_var(request()->query('deleted_answers', false), FILTER_VALIDATE_BOOLEAN);

        $answers = $questionManager->getAnswers($question, $answersDeleted);

        return view('admin.questions.show', compact('question', 'answers', 'answersDeleted'));

    }

    public function edit(Question $question)
    {
        $this->authorize('storeOrUpdateOrDelete', $question);

        return view('admin.questions.edit', compact('question'));

    }

    public function update(Question $question, UpdateQuestionRequest $request, QuestionManager $questionManager)
    {
        $this->authorize('storeOrUpdateOrDelete', $question);

        if ($question->test->status === Test::STATUS_ACTIVE) {
            return redirect()->back()
                ->withErrors('Редактирование невозможно, тест опубликован в каталоге');
        }

        $question = $questionManager->upsertQuestion($question, $request->validated());

        return redirect()->route(auth()->user()->role . '.tests.questions.show', $question)
            ->withSuccess('Вопрос обновлен');
    }

    public function destroy(Question $question)
    {
        $this->authorize('storeOrUpdateOrDelete', $question);

        $question->delete();

        return redirect()->route(auth()->user()->role . '.tests.show', $question->test->id)
            ->withSuccess('Вопрос удален');
    }

    public function restore($id)
    {
        $question = Question::onlyTrashed()->find($id);
        $this->authorize('storeOrUpdateOrDelete', $question);
        $question->restore();

        return back()->withSuccess('Вопрос восстановлен');
    }

    public function updateQuestionSequence(UpdateQuestionSequenceRequest $request)
    {

        $values = [];

        foreach ($request->get('values') as $value) {
            $id = explode(',', $value)[0];
            $number = explode(',', $value)[1];

            $question = Question::findOrFail($id);

            $this->authorize('storeOrUpdateOrDelete', $question);

            $values[] = [
                'id' => $id,
                'number' => $number,
            ];
        }

        batch()
            ->update(new Question(), $values, 'id');
    }

    protected function prepareQuestion(): Question
    {
        return new Question([
            'test_id' => (int) request()
                ->get('test_id'),
        ]);
    }
}
