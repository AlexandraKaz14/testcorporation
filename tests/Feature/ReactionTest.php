<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Reaction;
use App\Models\Test;
use App\Models\Variable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testPageCreateReaction()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $answer = Answer::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.answers.show', $answer));
        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.answers.reactions.create', [
            'answer_id' => $answer,
        ]));
        $response->assertStatus(200);
    }

    public function testStoreReaction()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $answer = Answer::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.answers.show', $answer));
        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.answers.reactions.create', [
            'answer_id' => $answer,
        ]));
        $response->assertStatus(200);
        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
        ]);
        $response = $this->post(route('admin.tests.questions.answers.reactions.store'), [
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'question_id' => $question->id,
            'operation' => Reaction::OPERATION_ADDITION,
            'value' => '30',
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Реакция создана');
    }

    public function testShowReaction()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $this->get(route('admin.tests.show', $test));
        Question::factory()->create();
        $question = Question::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.show', $question));
        $response->assertStatus(200);
        $answer = Answer::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.answers.show', $answer));
        $response->assertStatus(200);
        $this->get(route('admin.tests.questions.answers.reactions.create', [
            'answer_id' => $answer,
        ]));
        $response->assertStatus(200);
        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
        ]);
        $response = $this->post(route('admin.tests.questions.answers.reactions.store'), [
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'question_id' => $question->id,
            'operation' => Reaction::OPERATION_ADDITION,
            'value' => '30',
        ]);
        $response->assertStatus(302);
        $reaction = Reaction::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.answers.reactions.show', $reaction));
        $response->assertSee('30');
        $this->assertDatabaseHas('reactions', [
            'value' => '30',
        ]);

    }

    public function testUpdateReaction()
    {
        $this->loginByAdmin();

        $test = Test::factory()->create();
        $question = Question::factory()->create([
            'test_id' => $test->id,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
        ]);

        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
        ]);
        $variable2 = Variable::factory()->create([
            'test_id' => $test->id,
        ]);

        $response = $this->post(route('admin.tests.questions.answers.reactions.store'), [
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'question_id' => $question->id,
            'operation' => Reaction::OPERATION_ADDITION,
            'value' => '30',
        ]);
        $response->assertStatus(302);
        $reaction = Reaction::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.questions.answers.reactions.edit', $reaction));
        $response->assertStatus(200);
        $this->patch(route('admin.tests.questions.answers.reactions.update', $reaction), [
            'answer_id' => $answer->id,
            'variable_id' => $variable2->id,
            'question_id' => $question->id,
            'operation' => Reaction::OPERATION_SUBTRACTION,
            'value' => '50',
        ])
            ->assertStatus(302);
        $this->assertDatabaseHas('reactions', [
            'value' => '50',
            'operation' => 'subtraction',
        ]);

    }

    public function testDestroyReaction()
    {
        $this->loginByAdmin();

        $test = Test::factory()->create();
        $question = Question::factory()->create([
            'test_id' => $test->id,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
        ]);

        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
        ]);

        $response = $this->post(route('admin.tests.questions.answers.reactions.store'), [
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'question_id' => $question->id,
            'operation' => Reaction::OPERATION_ADDITION,
            'value' => '30',
        ]);
        $response->assertStatus(302);
        $reaction = Reaction::query()->latest('id')->first();
        $this->delete(route('admin.tests.questions.answers.reactions.destroy', $reaction));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Реакция удалена');
    }

    public function testValidationValue()
    {
        $this->loginByAdmin();

        $test = Test::factory()->create();
        $question = Question::factory()->create([
            'test_id' => $test->id,
        ]);
        $answer = Answer::factory()->create([
            'question_id' => $question->id,
        ]);

        $variable1 = Variable::factory()->create([
            'test_id' => $test->id,
        ]);

        $response = $this->post(route('admin.tests.questions.answers.reactions.store'), [
            'answer_id' => $answer->id,
            'variable_id' => $variable1->id,
            'question_id' => $question->id,
            'operation' => Reaction::OPERATION_ADDITION,
            'value' => '-30',
        ]);
        $response->assertSessionHasErrors(['value']);
    }
}
