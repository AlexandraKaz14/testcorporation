<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Result;
use App\Models\Test;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CreateTestFromJson extends Command
{
    protected $signature = 'app:create-test-from-json {jsonFilePath}';

    protected $description = 'Creates tests from json';

    public function handle()
    {
        $jsonFilePath = $this->argument('jsonFilePath');
        if (!file_exists(base_path($jsonFilePath))) {
            $this->error('File not found!');
            return;
        }
        $jsonContent = file_get_contents($jsonFilePath);
        $tests = json_decode($jsonContent, true);

        DB::transaction(function () use ($tests) {
            //создание пользователя
            $user = User::whereName('Test User')->take(1)->first();
            if (!$user) {
                $user = User::create([
                    'name' => 'Test User',
                    'email' => 'test@test.test',
                    'password' => bcrypt('password'),
                    'role' => User::ROLE_ADMIN,
                    'status' => User::STATUS_ACTIVE,
                    'verified_at' => now(),
                ]);
            }
            $this->info('User create...');

            //обходим тесты
            foreach ($tests as $testData) {

                if ($testData['picture']) {
                    $imageContents = file_get_contents($testData['picture']);
                    $path = Storage::disk()->put('pictures/' . uniqid() . '.jpg', $imageContents);
                    $this->info('Picture uploaded...');
                }

                // Создание теста
                $test = Test::create([
                    'title' => $testData['title'],
                    'description' => $testData['description'],
                    'slug' => $testData['slug'] . '-' . now()->timestamp,
                    'picture' => $testData['picture'] ? $path : null,
                    'tags' => json_encode($testData['tags']),
                    'categories' => json_encode($testData['categories']),
                    'user_id' => $user->id,
                ]);
                $this->info('Test created...');

                // Создание переменных
                foreach ($testData['variables'] as $variableData) {
                    Variable::create([
                        'test_id' => $test->id,
                        'name' => $variableData['name'],
                        'start_value' => $variableData['init'],
                    ]);
                    $this->info('Variable created...');
                }

                // Создание вопросов
                $questionNumber = 1;
                foreach ($testData['questions'] as $questionData) {

                    if ($questionData['picture']) {
                        $imageContents = file_get_contents($questionData['picture']);
                        $path = Storage::disk()->put('pictures/' . uniqid() . '.jpg', $imageContents);
                        $this->info('Picture uploaded...');
                    }

                    $question = Question::create([
                        'test_id' => $test->id,
                        'text' => $questionData['text'],
                        'picture' => $questionData['picture'] ? $path : null,
                        'number' => $questionNumber++,
                        'type' => Question::TYPE_ONLY_ANSWER,
                    ]);
                    $this->info('Question created...');

                    // Создание ответов
                    $answerNumber = 1;
                    foreach ($questionData['answers'] as $answerData) {

                        if ($answerData['picture']) {
                            $imageContents = file_get_contents($answerData['picture']);
                            $path = Storage::disk()->put('pictures/' . uniqid() . '.jpg', $imageContents);
                            $this->info('Picture uploaded...');
                        }

                        $answer = Answer::create([
                            'question_id' => $question->id,
                            'text' => $answerData['text'],
                            'picture' => $answerData['picture'] ? $path : null,
                            'number' => $answerNumber++,
                        ]);
                        $this->info('Answer created...');

                        // Обработка реакций на ответ
                        if (isset($answerData['reactions'])) {
                            foreach ($answerData['reactions'] as $reactionData) {
                                Reaction::create([
                                    'answer_id' => $answer->id,
                                    'variable_id' => $test->variables()
                                        ->where('name', $reactionData['variable'])->get()->first()->id,
                                    'operation' => $reactionData['operation'],
                                    'value' => $reactionData['value'],
                                ]);
                                $this->info('Reaction created...');
                            }
                        }
                    }
                }

                // Создание результатов
                $resultNumber = 1;
                foreach ($testData['results'] as $resultData) {
                    if ($resultData['picture']) {
                        $imageContents = file_get_contents($resultData['picture']);
                        $path = Storage::disk()->put('pictures/' . uniqid() . '.jpg', $imageContents);
                        $this->info('Picture uploaded...');
                    }

                    Result::create([
                        'test_id' => $test->id,
                        'condition' => $resultData['condition'],
                        'text' => $resultData['text'],
                        'picture' => $resultData['picture'] ? $path : null,
                        'number' => $resultNumber++,
                    ]);
                    $this->info('Result created...');
                }
            }
        });

        $this->info('Tests created successfully!');
    }
}
