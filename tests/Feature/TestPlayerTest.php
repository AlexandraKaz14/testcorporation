<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Result;
use App\Models\Tag;
use App\Models\TakingTest;
use App\Models\Test;
use App\Models\Theme;
use App\Models\User;
use App\Models\Variable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestPlayerTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenPlayer(): void
    {
        $this->loginByAdmin();
        $user = User::factory()->create([
            'name' => 'User Name',
        ]);
        $theme = Theme::factory()->create([
            'title' => 'Темная тема',
        ]);
        $test = Test::factory()->create([
            'user_id' => $user->id,
            'title' => 'Тест проверка',
            'slug' => 'test-proverka',
            'description' => 'Здесь что-то написано про тест',
            'theme_id' => $theme->id,
        ]);

        $response = $this->get(route('player.open', $test->slug));
        $response->assertStatus(200);
    }

    public function testMetaDataReturnsCorrectResult()
    {
        $this->loginByAdmin();
        $user = User::factory()->create([
            'name' => 'User Name',
        ]);

        $tag1 = Tag::factory()->create([
            'name' => 'кот',
        ]);
        $category1 = Category::factory()->create([
            'title' => 'Наука',
        ]);

        $test = Test::factory()->create([
            'user_id' => $user->id,
            'title' => 'Тест проверка',
            'slug' => 'test-my-test',
            'description' => 'Здесь что-то написано про тест',
        ]);
        $test->tags()
            ->attach($tag1->id);
        $test->categories()
            ->attach($category1->id);

        $question = Question::factory()->create([
            'test_id' => $test->id,
            'text' => 'вопрос 1',
        ]);

        $answer = Answer::factory()->create([
            'question_id' => $question->id,
            'text' => 'ответ 1',
        ]);

        $response = $this->get(route('player.meta_data', $test->slug));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'test' => [
                'id',
                'title',
                'description',
                'picture',
                'author' => [
                    'id',
                    'name',
                ],
                'tags' => [
                    ['name'],
                ],
                'categories' => [
                    ['title'],
                ],
                'questions' => [
                    [
                        'id',
                        'text',
                        'picture',
                        'answers' => [
                            [
                                'id',
                                'text',
                                'picture',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $response->assertJson([
            'test' => [
                'id' => $test->id,
                'title' => 'Тест проверка',
                'description' => 'Здесь что-то написано про тест',
                'author' => [
                    'id' => $user->id,
                    'name' => 'User Name',
                ],
                'tags' => [
                    [
                        'name' => 'кот',
                    ],
                ],
                'categories' => [
                    [
                        'title' => 'Наука',
                    ],
                ],
                'questions' => [
                    [
                        'id' => $question->id,
                        'text' => 'вопрос 1',
                        'answers' => [
                            [
                                'id' => $answer->id,
                                'text' => 'ответ 1',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function testFinishWithCorrectDataAndResult()
    {
        $this->loginByAdmin();
        $user = User::factory()->create();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);

        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
            'name' => 'variable1',
            'start_value' => 10,
        ]);
        $variable2 = Variable::factory()->create([
            'test_id' => $test->id,
            'name' => 'variable2',
            'start_value' => 20,
        ]);

        $question = Question::factory()->create([
            'test_id' => $test->id,
            'number' => 1,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
        ]);

        Reaction::factory()->create([
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'operation' => 'addition',
            'value' => 5,
        ]);
        Reaction::factory()->create([
            'answer_id' => $answer->id,
            'variable_id' => $variable2->id,
            'operation' => 'multiplication',
            'value' => 2,
        ]);

        Result::factory()->create([
            'test_id' => $test->id,
            'condition' => 'variable1 >= 15 && variable2 >= 40',
            'text' => 'Результат теста',
            'number' => 1,
        ]);

        $data = [
            'answers' => [$answer->id],
        ];
        $response = $this->postJson(route('player.finish', $test->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('taking_tests', [
            'test_id' => $test->id,
            'generated_text_result' => 'Результат теста',
        ]);
        $takingTest = TakingTest::where('test_id', $test->id)->first();
        $this->assertEquals(route('player.result', $takingTest->code), $response->json('redirect'));
    }

    public function testFinishWithoutSuitableResult()
    {
        $this->loginByAdmin();
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);

        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
            'name' => 'variable1',
            'start_value' => 10,
        ]);
        $variable2 = Variable::factory()->create([
            'test_id' => $test->id,
            'name' => 'variable2',
            'start_value' => 20,
        ]);

        $question = Question::factory()->create([
            'test_id' => $test->id,
            'number' => 1,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
        ]);

        Reaction::factory()->create([
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'operation' => 'addition',
            'value' => 5,
        ]);
        Reaction::factory()->create([
            'answer_id' => $answer->id,
            'variable_id' => $variable2->id,
            'operation' => 'multiplication',
            'value' => 2,
        ]);

        Result::factory()->create([
            'test_id' => $test->id,
            'condition' => 'variable1 >= 50 && variable2 <= 10',
            'text' => 'Результат теста',
            'number' => 1,
        ]);

        $data = [
            'answers' => [$answer->id],
        ];

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Подходящий результат не найден');
        $this->postJson(route('player.finish', $test->id), $data);
    }

    public function testFinishNotValidData()
    {
        $this->loginByAdmin();
        $user = User::factory()->create();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $test2 = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $question1 = Question::factory()->create([
            'test_id' => $test->id,
            'number' => 1,
        ]);
        $question2 = Question::factory()->create([
            'test_id' => $test2->id,
            'number' => 2,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question1->id,
        ]);
        $answer2 = Answer::factory()->create([
            'question_id' => $question2->id,
        ]);
        $answer3 = Answer::factory()->create([
            'question_id' => $question1->id,
        ]);
        $answer4 = Answer::factory()->create([
            'question_id' => $question1->id,
        ]);
        $answer5 = Answer::factory()->create([
            'question_id' => $question1->id,
        ]);

        $data = [
            'answers' => [$answer->id, $answer2->id, $answer3->id, $answer4->id, $answer5->id, $answer5->id],
        ];

        $response = $this->postJson(route('player.finish', $test->id), $data);
        $response->assertJsonValidationErrors(['answers']);
    }

    public function testTwoAnswersToOneQuestion()
    {
        $this->loginByAdmin();
        $user = User::factory()->create();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $question1 = Question::factory()->create([
            'test_id' => $test->id,
            'number' => 1,
        ]);
        Question::factory()->create([
            'test_id' => $test->id,
            'number' => 2,
        ]);
        $answer1 = Answer::factory()->create([
            'question_id' => $question1->id,
        ]);
        $answer2 = Answer::factory()->create([
            'question_id' => $question1->id,
        ]);

        $data = [
            'answers' => [$answer1->id, $answer2->id],
        ];

        $response = $this->postJson(route('player.finish', $test->id), $data);
        $response->assertJsonValidationErrors(['answers']);
    }

    public function testFinishMathematicalOperations()
    {
        $this->loginByAdmin();
        $user = User::factory()->create();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);

        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
            'name' => 'variable1',
            'start_value' => 10,
        ]);
        $variable2 = Variable::factory()->create([
            'test_id' => $test->id,
            'name' => 'variable2',
            'start_value' => 20,
        ]);

        $question = Question::factory()->create([
            'test_id' => $test->id,
            'number' => 1,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
        ]);

        Reaction::factory()->create([
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'operation' => 'subtraction',
            'value' => 5,
        ]);

        Reaction::factory()->create([
            'answer_id' => $answer->id,
            'variable_id' => $variable2->id,
            'operation' => 'division',
            'value' => 2,
        ]);

        Result::factory()->create([
            'test_id' => $test->id,
            'condition' => 'variable1 >= 5 && variable2 >= 10',
            'text' => 'Результат теста',
            'number' => 1,
        ]);

        $data = [
            'answers' => [$answer->id],
        ];
        $response = $this->postJson(route('player.finish', $test->id), $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('taking_tests', [
            'test_id' => $test->id,
            'generated_text_result' => 'Результат теста',
        ]);
        $takingTest = TakingTest::where('test_id', $test->id)->first();
        $this->assertEquals(route('player.result', $takingTest->code), $response->json('redirect'));
    }

    public function testResultViewTakingTest()
    {
        $this->loginByAdmin();

        $theme = Theme::factory()->create([
            'title' => 'Фиолетовая тема',
            'css_style' => 'color:red',
        ]);

        $test = Test::factory()->create([
            'slug' => 'test-slug',
        ]);

        $takingTest = TakingTest::factory()->create([
            'test_id' => $test->id,
            'code' => 'qwertyuiop',
            'generated_text_result' => 'Результат теста',
        ]);

        $test->theme()
            ->associate($theme);
        $test->save();

        $response = $this->get(route('player.result', $takingTest->code));
        $response->assertStatus(200);
        $response->assertViewIs('player.result');
        $response->assertViewHas('takingTest', function ($viewTakingTest) use ($takingTest) {
            return $viewTakingTest->id === $takingTest->id &&
                $viewTakingTest->generated_text_result === $takingTest->generated_text_result;
        });
        $response->assertViewHas('slug', 'test-slug');
    }
}
