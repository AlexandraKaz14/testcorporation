<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Tag;
use App\Models\TakingTest;
use App\Models\Test;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class TestPlayerService
{
    public function formationResultData($test)
    {
        $result = [];
        $result['test'] = [
            'id' => $test->id,
            'title' => $test->title,
            'description' => $test->description,
            'picture' => $test->picture ? Storage::url($test->picture) : $test->picture,
            'author' => [
                'id' => $test->user->id,
                'name' => $test->user->name,
            ],
            'meta_description' => $test->meta_description,
            'meta_keywords' => $test->meta_keywords,
            'tags' => $test->tags->transform(function (Tag $tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ];
            }),

            'categories' => $test->categories->transform(function (Category $category) {
                return [
                    'id' => $category->id,
                    'title' => $category->title,
                ];
            }),
            'questions' => $test->questions->transform(function (Question $question) {
                return [
                    'id' => $question->id,
                    'text' => $question->text,
                    'picture' => $question->picture ? Storage::url($question->picture) : $question->picture,
                    'answers' => $question->answers->transform(function (Answer $answer) {
                        return [
                            'id' => $answer->id,
                            'text' => $answer->text,
                            'picture' => $answer->picture ? Storage::url($answer->picture) : $answer->picture,
                        ];
                    }),
                ];
            }),

        ];
        return $result;
    }

    public function calculationResults($test, $answers)
    {
        $variables = $this->initializeVariables($test);
        $reactions = $this->getSortedReactions($answers);

        foreach ($reactions as $reaction) {
            $variableName = $reaction->variable->name;

            switch ($reaction->operation) {
                case 'addition':
                    $variables[$variableName] += $reaction->value;
                    break;
                case 'subtraction':
                    $variables[$variableName] -= $reaction->value;
                    break;
                case 'multiplication':
                    $variables[$variableName] *= $reaction->value;
                    break;
                case 'division':
                    if ($reaction->value !== 0) {
                        $variables[$variableName] /= $reaction->value;
                    }
                    break;
                default:
                    throw new \Exception('Неизвестная операция: ' . $reaction->operation);
            }
        }

        return $variables;

    }

    public function createFinalResult(Test $test, array $data, array $variables, $request): TakingTest
    {
        //        $results = $test->results()
        //            ->orderBy('number')
        //            ->get();
        //
        //        $expressionLanguage = new ExpressionLanguage();
        //
        //        $guestId = session()
        //            ->get('guest_id', Str::uuid());
        //        session()
        //            ->put('guest_id', $guestId);
        //
        //        \Log::info('Факультеты перед вычислением:', [
        //            'гриффиндор' => $variables['гриффиндор'],
        //            'слизерин' => $variables['слизерин'],
        //            'когтевран' => $variables['когтевран'],
        //            'пуффендуй' => $variables['пуффендуй'],
        //        ]);
        //        foreach ($results as $result) {
        //            $condition = $result->condition;
        //            \Log::info("Проверяем выражение: {$condition}");
        //
        //            if ($expressionLanguage->evaluate($condition, $variables)) {
        //                $finalResult = new TakingTest();
        //                $finalResult->test_id = $test->id;
        //                $finalResult->code = Str::random(10);
        //                $finalResult->ip_address = $request->ip();
        //                $finalResult->request = json_encode($data);
        //                $finalResult->generated_text_result = $result->text;
        //                $finalResult->generated_picture_result = $result->picture;
        //                $finalResult->user_id = auth()
        //                    ->id();
        //                $finalResult->guest_id = auth()
        //                    ->check() ? null : $guestId;
        //                $finalResult->is_temporary = in_array($test->status, [Test::STATUS_DRAFT, Test::STATUS_MODERATION], true);
        //                $finalResult->save();
        //
        //                return $finalResult;
        //            }
        //        }
        //        throw new \Exception('Подходящий результат не найден');

        $results = $test->results()
            ->orderByDesc('number') // Проверяем сначала самые "важные" результаты
            ->get();

        $expressionLanguage = new ExpressionLanguage();

        $guestId = session()
            ->get('guest_id', Str::uuid());
        session()
            ->put('guest_id', $guestId);

        \Log::info('Факультеты перед вычислением:', $variables);

        $finalResult = null;

        foreach ($results as $result) {
            $condition = $result->condition;
            \Log::info("Проверяем выражение: {$condition}");

            if ($expressionLanguage->evaluate($condition, $variables)) {
                \Log::info("Выражение сработало: {$condition}");
                $finalResult = $result;
                break; // Нашли самое подходящее, дальше проверять не нужно
            }
        }

        if (!$finalResult) {
            throw new \Exception('Подходящий результат не найден');
        }

        $takingTest = new TakingTest();
        $takingTest->test_id = $test->id;
        $takingTest->code = Str::random(10);
        $takingTest->ip_address = $request->ip();
        $takingTest->request = json_encode($data);
        $takingTest->generated_text_result = $finalResult->text;
        $takingTest->generated_picture_result = $finalResult->picture;
        $takingTest->user_id = auth()
            ->id();
        $takingTest->guest_id = auth()
            ->check() ? null : $guestId;
        $takingTest->is_temporary = in_array($test->status, [Test::STATUS_DRAFT, Test::STATUS_MODERATION], true);
        $takingTest->save();

        return $takingTest;

    }

    protected function initializeVariables(Test $test): array
    {
        $variables = [];
        foreach ($test->variables as $variable) {
            $variableName = $variable->name;
            $variableStartValue = $variable->start_value;
            $variables[$variableName] = $variableStartValue;
        }
        return $variables;
    }

    protected function getSortedReactions(array $answers)
    {
        return Reaction::whereIn('answer_id', $answers)
            ->with('variable')
            ->get()
            ->sortBy(fn ($reaction) => $reaction->answer->question->number);
    }
}
