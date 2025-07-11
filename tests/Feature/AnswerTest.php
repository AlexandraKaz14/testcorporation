<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    public function testPageCreateAnswer()
    {
        $user = $this->loginByAdmin();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);

        $question = Question::factory()->create([
            'test_id' => $test->id,
            'text' => 'Вопрос 1',
        ]);
        $response = $this->get(route('admin.tests.questions.show', $question));

        $this->get(route('admin.tests.questions.answers.create', [
            'question_id' => $question->id,
        ]));
        $response->assertStatus(200);
        $response->assertSee('Вопрос 1');

    }

    public function testStoreAnswer()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create([
            'text' => 'Text',
        ]);
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.answers.create'));
        $response->assertStatus(200);
        $response->assertSee('Text');

        Storage::fake('public');
        $file = UploadedFile::fake()->image('Ответ1.jpg');

        $response = $this->post(route('admin.tests.questions.answers.store'), [
            'text' => 'Описание вопроса',
            'number' => 1,
            'picture' => $file,
            'question_id' => $question->id,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Ответ создан');
    }

    public function testShowPageAnswer()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('Ответ1.jpg');

        $this->post(route('admin.tests.questions.answers.store'), [
            'text' => 'Текст ответа',
            'number' => 1,
            'picture' => $file,
            'question_id' => $question->id,
        ])
            ->assertStatus(302);

        $answer = Answer::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.answers.show', $answer));
        $response->assertSee('Текст ответа');
        $this->assertDatabaseHas('answers', [
            'text' => 'Текст ответа',
        ]);
    }

    public function testUpdateAnswer()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('Ответ1.jpg');
        $file2 = UploadedFile::fake()->image('Ответ2.jpg');
        $this->post(route('admin.tests.questions.answers.store'), [
            'text' => 'Текст ответа',
            'number' => 1,
            'picture' => $file,
            'question_id' => $question->id,
        ])
            ->assertStatus(302);
        $answer = Answer::query()->latest('id')->first();
        Storage::disk()->assertExists($answer->picture);
        $picture1 = $answer->picture;
        $response = $this->get(route('admin.tests.questions.answers.edit', $answer));
        $response->assertStatus(200);

        Storage::disk()->assertExists($picture1);

        $this->patch(route('admin.tests.questions.answers.update', $answer), [
            'text' => 'Текст ответа новый',
            'number' => 1,
            'picture' => $file2,
            'question_id' => $question->id,
        ])->assertStatus(302);
        $answer->refresh();

        Storage::disk()->assertExists($answer->picture);
        Storage::disk()->delete($picture1);
        Storage::disk()->assertMissing($picture1);

        $this->assertDatabaseHas('answers', [
            'text' => 'Текст ответа новый',
        ]);

        $response = $this->get(route('admin.tests.questions.answers.show', $answer));
        $response->assertSee('Текст ответа новый');
    }

    public function testDeleteAnswer()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);

        Storage::fake('public');
        $file = UploadedFile::fake()->image('Ответ1.jpg');
        $this->post(route('admin.tests.questions.answers.store'), [
            'text' => 'Ответ на удаление',
            'number' => 1,
            'picture' => $file,
            'question_id' => $question->id,
        ])
            ->assertStatus(302);
        $answer = Answer::query()->latest('id')->first();
        $this->assertDatabaseHas('answers', [
            'id' => $answer->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.tests.questions.answers.destroy', $answer));
        $this->assertSoftDeleted('answers', [
            'id' => $answer->id,
            'deleted_at' => now(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Ответ удален');
        $response = $this->get(route('admin.tests.questions.answers.show', $answer));
        $response->assertStatus(404);
    }

    public function testRestoreAnswer()
    {
        $this->loginByAdmin();

        $deleteAnswer = Answer::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->get(route('admin.tests.questions.answers.show', $deleteAnswer->id))
            ->assertStatus(404);
        $this->assertSoftDeleted('answers', [
            'id' => $deleteAnswer->id,
        ]);

        $response = $this->post(route('admin.tests.questions.answers.restore', $deleteAnswer->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Ответ восстановлен');
        $this->assertDatabaseHas('answers', [
            'id' => $deleteAnswer->id,
            'deleted_at' => null,
        ]);
        $this->get(route('admin.tests.questions.answers.show', $deleteAnswer->id))
            ->assertStatus(200);
    }

    public function testShowDeletedAnswers()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $question = Question::factory()->create();

        Answer::factory()->create([
            'text' => 'Ответ удаленный',
            'deleted_at' => now(),
        ]);

        $this->get(route('admin.tests.questions.show', [
            'question' => $question->id,
            'deleted' => 1,
        ]))
            ->assertStatus(200);
    }

    public function testPageShowOnlyTrashedAnswer()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $deleteAnswer = Answer::factory()->create([
            'text' => 'Удаленный ответ',
            'deleted_at' => now(),
        ]);

        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.answers.show', $deleteAnswer->id))
            ->assertStatus(404);
    }

    public function testUpdateAnswersSequence()
    {

        $this->loginByAdmin();
        Test::factory()->create();
        $question = Question::factory()->create();

        Answer::factory()->create();
        $answer1 = Answer::factory()->create([
            'number' => 1,
            'question_id' => $question->id,
        ]);
        $answer2 = Answer::factory()->create([
            'number' => 2,
            'question_id' => $question->id,
        ]);

        $newSequence = [
            [
                'id' => $answer1->id,
                'number' => 2,
            ],
            [
                'id' => $answer2->id,
                'number' => 1,
            ],
        ];

        $response = $this->post(route('admin.tests.questions.answer_sequence', [
            'question' => $question->id,
        ]), [
            'values' => [
                "{$answer1->id},2",
                "{$answer2->id},1",
            ],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('answers', [
            'id' => $answer1->id,
            'number' => 2,
        ]);

        $this->assertDatabaseHas('answers', [
            'id' => $answer2->id,
            'number' => 1,
        ]);
    }
}
