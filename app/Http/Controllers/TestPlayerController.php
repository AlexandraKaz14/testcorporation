<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FinishAnswersRequest;
use App\Models\TakingTest;
use App\Models\Test;
use App\Services\TestPlayerService;

class TestPlayerController extends Controller
{
    protected $testPlayerService;

    public function __construct(TestPlayerService $testPlayerService)
    {
        $this->testPlayerService = $testPlayerService;
    }

    public function open(string $slug)
    {
        $test = Test::where('slug', $slug)->firstOrFail();
        $theme = $test->theme;

        return view('player.open', compact('test', 'theme'));
    }

    public function metaData(string $slug)
    {
        $test = Test::where('slug', $slug)->firstOrFail();

        return $this->testPlayerService->formationResultData($test);

    }

    public function finish(FinishAnswersRequest $request, int $test)
    {
        $test = Test::query()->findOrFail($test);
        $data = $request->validated();
        $answers = $data['answers'];
        $result = $this->testPlayerService->calculationResults($test, $answers);
        $finalResult = $this->testPlayerService->createFinalResult($test, $data, $result, $request);
        return response()->json([
            'redirect' => route('player.result', $finalResult->code),
        ]);
    }

    public function result(string $code)
    {
        $takingTest = TakingTest::query()->where('code', $code)->first();
        $theme = $takingTest->test->theme;
        $slug = $takingTest->test->slug;

        $shareUrl = route('player.result', [
            'code' => $takingTest->code,
        ]);

        return view('player.result', [
            'takingTest' => $takingTest,
            'theme' => $theme,
            'slug' => $slug,
            'shareUrl' => $shareUrl,
        ]);
    }
}
