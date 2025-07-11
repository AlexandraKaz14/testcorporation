<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Requests\UpdateAnswerSequenceRequest;
use App\Models\Answer;
use App\Services\AnswerManager;

class AnswerController extends Controller
{
    public function create()
    {
        $answer = $this->prepareAnswer();

        $this->authorize('viewOrCreate', $answer);

        return view('admin.answers.create', compact('answer'));
    }

    public function store(AnswerManager $answerManager, CreateAnswerRequest $request)
    {
        $answer = $this->prepareAnswer();
        $this->authorize('viewOrCreateOrUpdate', $answer);
        $answer = $answerManager->upsertAnswer(new Answer(), $request->validated());

        return redirect()
            ->route(auth()->user()->role . '.tests.questions.show', $answer->question_id)
            ->withSuccess('Ответ создан');
    }

    public function show(Answer $answer, AnswerManager $answerManager)
    {
        $this->authorize('viewOrCreate', $answer);

        $reactions = $answerManager->getReactions($answer);
        return view('admin.answers.show', compact('answer', 'reactions'));
    }

    public function edit(Answer $answer)
    {
        $this->authorize('viewOrCreateOrUpdate', $answer);

        return view('admin.answers.edit', compact('answer'));
    }

    public function update(Answer $answer, UpdateAnswerRequest $request, AnswerManager $answerManager)
    {
        $this->authorize('viewOrCreateOrUpdate', $answer);

        $answer = $answerManager->upsertAnswer($answer, $request->validated());
        return redirect()->route(auth()->user()->role . '.tests.questions.answers.show', $answer)
            ->withSuccess('Ответ обновлен');
    }

    public function destroy(Answer $answer)
    {
        $this->authorize('deleteOrRestore', $answer);

        $answer->delete();

        return redirect()->route(auth()->user()->role . '.tests.questions.show', $answer->question->id)
            ->withSuccess('Ответ удален');
    }

    public function restore($id)
    {
        $answer = Answer::onlyTrashed()->find($id);
        $this->authorize('deleteOrRestore', $answer);

        $answer->restore();

        return back()->withSuccess('Ответ восстановлен');
    }

    public function updateAnswerSequence(UpdateAnswerSequenceRequest $request): void
    {
        $values = [];
        foreach ($request->get('values') as $value) {
            $id = explode(',', $value)[0];
            $number = explode(',', $value)[1];
            $answer = Answer::findOrFail($id);
            $this->authorize('viewOrCreateOrUpdate', $answer);

            $values[] = [
                'id' => $id,
                'number' => $number,
            ];
        }

        batch()
            ->update(new Answer(), $values, 'id');
    }

    protected function prepareAnswer(): Answer
    {
        return new Answer([
            'question_id' => (int) request()
                ->get('question_id'),
        ]);
    }
}
