<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateReactionRequest;
use App\Http\Requests\UpdateReactionRequest;
use App\Models\Answer;
use App\Models\Reaction;
use App\Models\Variable;

class ReactionController extends Controller
{
    public function create()
    {
        $reaction = $this->prepareReaction();
        $this->authorize('viewOrCreateOrUpdate', $reaction);
        $answer = Answer::find($reaction->answer_id);
        $variables = Variable::where('test_id', $answer->question->test_id)->get();

        return view('admin.reactions.create', compact('reaction', 'answer', 'variables'));
    }

    public function store(CreateReactionRequest $request)
    {
        $reaction = $this->prepareReaction();
        $this->authorize('viewOrCreateOrUpdate', $reaction);

        $data = $request->validated();
        $reaction = Reaction::create($data);

        return redirect()
            ->route(auth()->user()->role . '.tests.questions.answers.show', $reaction->answer_id)
            ->withSuccess('Реакция создана');
    }

    public function edit(Reaction $reaction)
    {
        $this->authorize('viewOrCreateOrUpdate', $reaction);

        $variables = Variable::where('test_id', $reaction->answer->question->test_id)->get();
        return view('admin.reactions.edit', compact('reaction', 'variables'));
    }

    public function show(Reaction $reaction)
    {
        $this->authorize('view', $reaction);

        return view('admin.reactions.show', compact('reaction'));

    }

    public function update(Reaction $reaction, UpdateReactionRequest $request)
    {
        $this->authorize('viewOrCreateOrUpdate', $reaction);

        $data = $request->validated();
        $reaction->update($data);

        return redirect()->route(auth()->user()->role . '.tests.questions.answers.show', $reaction->answer_id)
            ->withSuccess('Реакция обновлена');

    }

    public function destroy(Reaction $reaction)
    {
        $this->authorize('delete', $reaction);

        $reaction->delete();
        return redirect()->route(auth()->user()->role . '.tests.questions.answers.show', $reaction->answer_id)
            ->withSuccess('Реакция удалена');
    }

    protected function prepareReaction(): Reaction
    {
        return new Reaction([
            'answer_id' => (int) request()
                ->get('answer_id'),
        ]);
    }
}
