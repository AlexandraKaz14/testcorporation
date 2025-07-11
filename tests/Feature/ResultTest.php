<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Result;
use App\Models\Tag;
use App\Models\Test;
use App\Models\Variable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ResultTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testPageCreateResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $response = $this->get(route('admin.tests.show', $test->id));
        $response->assertStatus(200);

        $this->get(route('admin.tests.results.create', [
            'test_id' => $test->id,
        ]));
        $response->assertStatus(200);
    }

    public function testStoreResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $variable1 = Variable::factory()->create([
            'name' => 'кот',
            'test_id' => $test->id,
        ]);
        $this->assertDatabaseHas('variables', [
            'name' => 'кот',
            'test_id' => $test->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('результат.jpg');
        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => 'кот >=20',
            'text' => 'такой результат',
            'picture' => $image,
            'number' => 1,
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');

    }

    public function testShowResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $variable1 = Variable::factory()->create([
            'name' => 'кот',
            'test_id' => $test->id,
        ]);
        $variable2 = Variable::factory()->create([
            'name' => 'пёс',
            'test_id' => $test->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('результат.jpg');
        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => "{$variable1->name} + {$variable2->name}",
            'text' => 'такой результат',
            'picture' => $image,
            'number' => 1,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');
        $result = Result::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.results.show', $result));
        $response->assertSee('(кот + пёс)');
        $this->assertDatabaseHas('results', [
            'condition' => '(кот + пёс)',
        ]);

    }

    public function testUpdateResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $variable1 = Variable::factory()->create([
            'name' => 'кот',
            'test_id' => $test->id,
        ]);
        $variable2 = Variable::factory()->create([
            'name' => 'пёс',
            'test_id' => $test->id,
        ]);

        $variable3 = Variable::factory()->create([
            'name' => 'гусь',
            'test_id' => $test->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('результат.jpg');
        $image2 = UploadedFile::fake()->image('результат2.jpg');
        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => "{$variable1->name} + {$variable2->name}",
            'text' => 'такой результат',
            'picture' => $image,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');
        $result = Result::query()->latest('id')->first();
        $this->patch(route('admin.tests.results.update', $result), [
            'test_id' => $test->id,
            'condition' => "{$variable1->name} + {$variable2->name} - {$variable3->name}",
            'text' => 'новый результат',
            'picture' => $image2,
        ])->assertRedirect()
            ->assertSessionHas('success', 'Результат обновлен');
        $this->assertDatabaseHas('results', [
            'condition' => '((кот + пёс) - гусь)',
        ]);

    }

    public function testEditResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $variable1 = Variable::factory()->create([
            'name' => 'кот',
            'test_id' => $test->id,
        ]);

        Storage::fake('public');
        $image = UploadedFile::fake()->image('результат.jpg');
        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => "{$variable1->name}",
            'text' => 'такой результат',
            'picture' => $image,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');
        $result = Result::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.results.edit', $result));
        $response->assertStatus(200);
    }

    public function testDeleteResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $variable = Variable::factory()->create([
            'name' => 'кот',
            'test_id' => $test->id,
        ]);

        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => "{$variable->name}",
            'text' => 'такой результат',
        ]);
        $response->assertStatus(302);
        $result = Result::query()->latest('id')->first();
        $this->delete(route('admin.tests.results.destroy', $result));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат удален');
    }

    public function testUpdateResultSequence()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();

        $result1 = Result::factory()->create([
            'number' => 1,
            'test_id' => $test->id,
        ]);
        $result2 = Result::factory()->create([
            'number' => 2,
            'test_id' => $test->id,
        ]);

        $newSequence = [
            [
                'id' => $result1->id,
                'number' => 2,
            ],
            [
                'id' => $result2->id,
                'number' => 1,
            ],
        ];

        $response = $this->post(route('admin.tests.result_sequence', [
            'test' => $test->id,
        ]), [
            'values' => [
                "{$result1->id},2",
                "{$result2->id},1",
            ],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('results', [
            'id' => $result1->id,
            'number' => 2,
        ]);

        $this->assertDatabaseHas('results', [
            'id' => $result2->id,
            'number' => 1,
        ]);
    }

    public function testUpdateVariableWithResult()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();

        $response = $this->post(route('admin.tests.variables.store'), [
            'name' => 'гриффиндор',
            'start_value' => 100,
            'test_id' => $test->id,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Переменная создана');

        $variable1 = Variable::query()->latest('id')->first();

        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => "{$variable1->name} === 50",
            'text' => 'Результат',
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');
        $result = Result::query()->latest('id')->first();

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'condition' => '(гриффиндор === 50)',
        ]);

        $this->patch(route('admin.tests.variables.update', $variable1), [
            'name' => 'слизерин',
            'start_value' => 100,
            'test_id' => $test->id,
        ])    ->assertStatus(302);
        $this->assertDatabaseHas('variables', [
            'name' => 'слизерин',
        ]);

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'condition' => '(слизерин === 50)',
        ]);
        $response = $this->get(route('admin.tests.results.show', $result));
        $response->assertSee('(слизерин === 50)');
    }

    public function testDeleteVariableInResult()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();

        $response = $this->post(route('admin.tests.variables.store'), [
            'name' => 'гриффиндор',
            'start_value' => 100,
            'test_id' => $test->id,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Переменная создана');

        $variable1 = Variable::query()->latest('id')->first();

        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => "{$variable1->name} === 50",
            'text' => 'Результат',
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Результат создан');

        $response = $this->delete(route('admin.tests.variables.destroy', $variable1));
        $response->assertStatus(302);
        $this->assertDatabaseHas('variables', [
            'id' => $variable1->id,
            'deleted_at' => null,
        ]);
    }

    public function testDeleteResultDefaultTrue()
    {
        $this->loginByAdmin();

        Storage::fake('public');
        $categories = Category::factory()->create();
        $tags = Tag::factory()->create();
        $file = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('admin.tests.store'), [
            'title' => 'Утка Поганка',
            'description' => 'Описание теста Утка Поганка',
            'picture' => $file,
            'categories' => $categories->pluck('id')
                ->toArray(),
            'tags' => $tags->pluck('name')
                ->toArray(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тест создан');
        $result = Result::query()->latest('id')->first();
        $response = $this->delete(route('admin.tests.results.destroy', $result));
        $response->assertStatus(302)
            ->assertSessionHasErrors();
        $this->assertModelExists($result);
    }

    public function testConditionInResult()
    {
        $this->loginByAdmin();
        $test = Test::factory()->create();
        $variable1 = Variable::factory()->create([
            'name' => 'кот',
            'test_id' => $test->id,
        ]);

        $response = $this->post(route('admin.tests.results.store'), [
            'test_id' => $test->id,
            'condition' => 'пес >=20',
            'text' => 'такой результат',
        ]);

        $response->assertRedirect()
            ->assertSessionHasErrors();
    }
}
