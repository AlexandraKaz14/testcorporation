<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testPageCreateQuestion()
    {
        $user = $this->loginByAdmin();
        $test = Test::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->get(route('admin.tests.show', [
            'test' => $test->id,
        ]));
        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.create', [
            'test_id' => $test->id,
        ]));
        $response->assertStatus(200);
    }

    public function testStoreQuestion()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('картинка.jpg');

        $response = $this->post(route('admin.tests.questions.store'), [
            'text' => 'Описание вопроса',
            'number' => 1,
            'picture' => $file,
            'type' => Question::TYPE_ONLY_ANSWER,
            'test_id' => $test->id,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Вопрос создан');
    }

    public function testShowQuestion()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();

        Storage::fake('public');
        $file = UploadedFile::fake()->image('картинка2.jpg');

        $this->post(route('admin.tests.questions.store'), [
            'text' => 'Вопрос три',
            'number' => 2,
            'picture' => $file,
            'type' => Question::TYPE_ONLY_ANSWER,
            'test_id' => $test->id,
        ])
            ->assertStatus(302);
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertSee('Вопрос три');
        $this->assertDatabaseHas('questions', [
            'text' => 'Вопрос три',
        ]);
    }

    public function testUpdateQuestion()
    {
        $this->loginByAdmin();
        Storage::fake('public');

        Test::factory()->create();

        $test = Test::query()->latest('id')->first();
        $file1 = UploadedFile::fake()->image('картинка1.jpg');
        $file2 = UploadedFile::fake()->image('картинка2.jpg');

        $this->post(route('admin.tests.questions.store'), [
            'text' => 'Вопрос новый',
            'number' => 1,
            'picture' => $file1,
            'type' => Question::TYPE_ONLY_ANSWER,
            'test_id' => $test->id,
        ])
            ->assertStatus(302);

        $question = Question::query()->latest('id')->first();
        Storage::disk()->assertExists($question->picture);

        $picture1 = $question->picture;

        $response = $this->get(route('admin.tests.questions.edit', $question));
        $response->assertStatus(200);

        $this->patch(route('admin.tests.questions.update', $question), [
            'text' => 'Вопрос редактированный',
            'number' => 3,
            'picture' => $file2,
            'type' => Question::TYPE_ONLY_ANSWER,
            'test_id' => $test->id,
        ])->assertStatus(302);

        $question->refresh();

        Storage::disk()->assertExists($question->picture);
        Storage::disk()->delete($picture1);

        Storage::disk()->assertMissing($picture1);

        $this->assertDatabaseHas('questions', [
            'text' => 'Вопрос редактированный',
        ]);

        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertSee('Вопрос редактированный');
    }

    public function testUpdateImpossibleTestActive()
    {
        $user = $this->loginByAdmin();
        $test = Test::factory()->create([
            'user_id' => $user->id,
            'status' => Test::STATUS_ACTIVE,
        ]);
        $question = Question::factory()->create([
            'test_id' => $test->id,
            'text' => 'Вопрос',
        ]);

        $this->patch(route('admin.tests.questions.update', $question->id), [
            'text' => 'Вопрос новый',
        ])->assertStatus(302)
            ->assertRedirect()
            ->assertSessionHas('errors');

        $this->assertDatabaseHas('questions', [
            'test_id' => $test->id,
            'text' => 'Вопрос',
        ]);
    }

    public function testDeleteQuestion()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        Storage::fake('public');
        $file = UploadedFile::fake()->image('test5.jpg');

        $this->post(route('admin.tests.questions.store'), [
            'text' => 'Вопрос на удаление',
            'number' => 5,
            'picture' => $file,
            'type' => Question::TYPE_ONLY_ANSWER,
            'test_id' => $test->id,
        ])
            ->assertStatus(302);
        $question = Question::query()->latest('id')->first();
        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.tests.questions.destroy', $question));
        $this->assertSoftDeleted('questions', [
            'id' => $question->id,
            'deleted_at' => now(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Вопрос удален');
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(404);
    }

    public function testRestoreQuestion()
    {
        $this->loginByAdmin();

        $deleteQuestion = Question::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->get(route('admin.tests.questions.show', $deleteQuestion->id))
            ->assertStatus(404);
        $this->assertSoftDeleted('questions', [
            'id' => $deleteQuestion->id,
        ]);

        $response = $this->post(route('admin.tests.questions.restore', $deleteQuestion->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Вопрос восстановлен');
        $this->assertDatabaseHas('questions', [
            'id' => $deleteQuestion->id,
            'deleted_at' => null,
        ]);
        $this->get(route('admin.tests.questions.show', $deleteQuestion->id))
            ->assertStatus(200);
    }

    public function testUpdateQuestionSequence()
    {

        $this->loginByAdmin();
        $test = Test::factory()->create();

        Question::factory()->create();
        $question1 = Question::factory()->create([
            'number' => 1,
            'test_id' => $test->id,
        ]);
        $question2 = Question::factory()->create([
            'number' => 2,
            'test_id' => $test->id,
        ]);

        $newSequence = [
            [
                'id' => $question1->id,
                'number' => 2,
            ],
            [
                'id' => $question2->id,
                'number' => 1,
            ],
        ];

        $response = $this->post(route('admin.tests.question_sequence', [
            'test' => $test->id,
        ]), [
            'values' => [
                "{$question1->id},2",
                "{$question2->id},1",
            ],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('questions', [
            'id' => $question1->id,
            'number' => 2,
        ]);

        $this->assertDatabaseHas('questions', [
            'id' => $question2->id,
            'number' => 1,
        ]);
    }

    public function testShowDeletedQuestions()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();

        Question::factory()->create([
            'text' => 'Вопрос удаленный',
            'deleted_at' => now(),
        ]);

        $this->get(route('admin.tests.show', [
            'test' => $test->id,
            'deleted' => 1,
        ]))
            ->assertStatus(200);
    }

    public function testPageShowOnlyTrashedQuestion()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        $deleteQuestion = Question::factory()->create([
            'text' => 'Удаленный вопрос',
            'deleted_at' => now(),
        ]);
        $response = $this->get(route('admin.tests.show', [
            'test' => $test->id,
            'deleted_questions' => true,
        ]));
        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.show', $deleteQuestion->id))
            ->assertStatus(404);
    }
}
