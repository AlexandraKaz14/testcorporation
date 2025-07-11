<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Http\Requests\UpdateResultsSequenceRequest;
use App\Models\Result;
use App\Models\Variable;
use App\Services\ResultManager;

class ResultController extends Controller
{
    public function create()
    {
        $result = $this->prepareResult();

        $this->authorize('viewOrCreateOrUpdate', $result);

        $variables = Variable::where('test_id', $result->test_id)->get();

        return view('admin.results.create', compact('result', 'variables'));
    }

    public function store(ResultManager $resultManager, CreateResultRequest $request)
    {
        $result = $this->prepareResult();

        $this->authorize('viewOrCreateOrUpdate', $result);

        $result = $resultManager->upsertResult(new Result(), $request->validated());

        return redirect()
            ->route(auth()->user()->role . '.tests.show', $result->test_id)
            ->withSuccess('Результат создан');
    }

    public function show(Result $result)
    {
        $this->authorize('view', $result);

        return view('admin.results.show', compact('result'));
    }

    public function edit(Result $result)
    {
        $this->authorize('viewOrCreateOrUpdate', $result);

        $variables = $result->test->variables;

        return view('admin.results.edit', compact('result', 'variables'));
    }

    public function update(Result $result, UpdateResultRequest $request, ResultManager $resultManager)
    {
        $this->authorize('viewOrCreateOrUpdate', $result);

        $result = $resultManager->upsertResult($result, $request->validated());
        return redirect()->route(auth()->user()->role . '.tests.results.show', $result)
            ->withSuccess('Результат обновлен');
    }

    public function destroy(Result $result)
    {
        $this->authorize('delete', $result);

        if ($result->is_default === true) {
            return redirect()->back()
                ->withErrors('Результат по умолчанию нельзя удалить');
        }
        $result->variables()
            ->detach();
        $result->delete();
        return redirect()->route(auth()->user()->role . '.tests.show', $result->test_id)
            ->withSuccess('Результат удален');
    }

    public function updateResultSequence(UpdateResultsSequenceRequest $request)
    {
        $values = [];
        foreach ($request->get('values') as $value) {
            $values[] = [
                'id' => explode(',', $value)[0],
                'number' => explode(',', $value)[1],
            ];
        }

        batch()
            ->update(new Result(), $values, 'id');
    }

    protected function prepareResult()
    {
        return new Result([
            'test_id' => (int) request()
                ->get('test_id'),
        ]);
    }
}
