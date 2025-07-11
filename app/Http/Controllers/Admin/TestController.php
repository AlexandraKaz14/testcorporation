<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DataTables\TestsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTestRequest;
use App\Http\Requests\IndexTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Models\Moderation;
use App\Models\Test;
use App\Services\TestManager;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index(TestsDataTable $dataTable, IndexTestRequest $request)
    {
        $this->authorize('viewAnyOrCreate', Test::class);

        return $dataTable
            ->render('admin.tests.index', [
                'startDate' => $request->get('startDate'),
                'endDate' => $request->get('endDate'),
            ]);
    }

    public function create()
    {
        $this->authorize('viewAnyOrCreate', Test::class);

        return view('admin.tests.create');
    }

    public function store(TestManager $testManager, CreateTestRequest $request)
    {
        $this->authorize('viewAnyOrCreate', Test::class);

        $test = $testManager->upsertTest(new Test(), $request->validated());

        return redirect()
            ->route(auth()->user()->role . '.tests.index', $test)
            ->withSuccess('Тест создан');
    }

    public function show(Test $test, TestManager $testManager)
    {
        $this->authorize('viewAnyOrCreate', $test);
        $questionsDeleted = filter_var(request()->query('deleted_questions', false), FILTER_VALIDATE_BOOLEAN);
        $variablesDeleted = filter_var(request()->query('deleted_variables', false), FILTER_VALIDATE_BOOLEAN);

        $questions = $testManager->getQuestions($test, $questionsDeleted);
        $variables = $testManager->getVariables($test, $variablesDeleted);
        $results = $testManager->getResults($test);

        return view('admin.tests.show', compact('test', 'questions', 'questionsDeleted', 'variablesDeleted', 'variables', 'results'));
    }

    public function edit(Test $test)
    {
        $this->authorize('viewOrUpdateOrDelete', $test);

        return view('admin.tests.edit', compact('test'));
    }

    public function update(TestManager $testManager, UpdateTestRequest $request, Test $test)
    {
        $this->authorize('viewOrUpdateOrDelete', $test);

        $test = $testManager->upsertTest($test, $request->validated());

        return redirect()->route(auth()->user()->role . '.tests.show', $test)
            ->withSuccess('Тест обновлен');
    }

    public function destroy(Test $test)
    {
        $this->authorize('viewOrUpdateOrDelete', $test);
        $test->delete();

        return redirect()->route(auth()->user()->role . '.tests.index')
            ->withSuccess('Тест удален');
    }

    public function restore($id)
    {
        $test = Test::onlyTrashed()->find($id);
        $this->authorize('viewOrUpdateOrDelete', $test);
        $test->restore();
        return back()->withSuccess('Тест восстановлен');
    }

    public function publish(Test $test)
    {
        $this->authorize('submitForPublication', $test);

        $hasQuestions = $test->questions()
            ->exists();
        $hasAnswers = $test->questions()
            ->whereHas('answers')
            ->exists();
        $hasResults = $test->results()
            ->exists();
        if ($hasQuestions && $hasAnswers && $hasResults) {
            $test->status = Test::STATUS_ACTIVE;
            $test->save();
            return redirect()->back()
                ->withSuccess('Тест успешно опубликован!');
        }
        return redirect()->back()
            ->withErrors('Невозможно опубликовать тест. Убедитесь, что у теста есть хотя бы один вопрос, ответ и результат.');
    }

    public function submitForModeration(Test $test)
    {
        $this->authorize('submitForModeration', $test);

        $hasQuestions = $test->questions()
            ->exists();
        $hasAnswers = $test->questions()
            ->whereHas('answers')
            ->exists();
        $hasResults = $test->results()
            ->exists();
        if (!($hasQuestions && $hasAnswers && $hasResults)) {
            return redirect()->back()
                ->withErrors('Невозможно отправить тест на модерацию. Убедитесь, что у теста есть хотя бы один вопрос, ответ и результат.');
        }

        DB::transaction(function () use ($test) {
            $test->update([
                'status' => Test::STATUS_MODERATION,
            ]);

            $moderation = Moderation::where('test_id', $test->id)->first();

            if ($moderation && $moderation->moderation_status === Moderation::MODERATION_STATUS_REJECTED) {
                $moderation->update([
                    'moderator_id' => null,
                    'rejection_reason' => null,
                    'moderation_at' => null,
                    'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
                ]);
            } else {
                Moderation::create([
                    'test_id' => $test->id,
                    'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
                ]);
            }
        });

        return redirect()->back()
            ->withSuccess('Тест успешно отправлен на модерацию!');

    }

    public function returnTestToDraft(Test $test)
    {
        DB::transaction(function () use ($test) {
            $test->update([
                'status' => Test::STATUS_DRAFT,
            ]);
            Moderation::where('test_id', $test->id)
                ->delete();
        });

        return redirect()->back()
            ->withSuccess('Тест в черновике, редактирование доступно');
    }
}
