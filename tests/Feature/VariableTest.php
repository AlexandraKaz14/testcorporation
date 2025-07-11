<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Test;
use App\Models\Variable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VariableTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testPageCreateVariable()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        $this->get(route('admin.tests.variables.create', [
            'test_id' => $test->id,
        ]));
        $response->assertStatus(200);
    }

    public function testStoreVariable()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();

        $response = $this->post(route('admin.tests.variables.store'), [
            'name' => 'Гриффиндор',
            'start_value' => 100,
            'test_id' => $test->id,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Переменная создана');
        $this->assertDatabaseHas('variables', [
            'test_id' => $test->id,
            'name' => 'гриффиндор',
            'start_value' => 100,
        ]);
    }

    public function testInvalidStartValueNotNumeric()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->post(route('admin.tests.variables.store'), [
            'name' => 'гриффиндор',
            'start_value' => 'string',
            'test_id' => $test->id,
        ]);
        $response->assertSessionHasErrors(['start_value']);
    }

    public function testPageEditVariable()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        $this->post(route('admin.tests.variables.store'), [
            'name' => 'Риск',
            'start_value' => 12.56,
            'test_id' => $test->id,
        ])->assertStatus(302);
        $variable = Variable::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.variables.edit', $variable));
        $response->assertStatus(200);
        $response->assertSee('риск');
    }

    public function testUpdateVariable()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        $this->post(route('admin.tests.variables.store'), [
            'name' => 'Удача',
            'start_value' => 1000,
            'test_id' => $test->id,
        ])->assertStatus(302);
        $variable = Variable::query()->latest('id')->first();
        $this->get(route('admin.tests.variables.edit', $variable));
        $this->patch(route('admin.tests.variables.update', $variable), [
            'name' => 'Успех',
            'start_value' => 10000,
            'test_id' => $test->id,
        ])    ->assertStatus(302);
        $this->assertDatabaseHas('variables', [
            'name' => 'успех',
        ]);
        $response = $this->get(route('admin.tests.variables.show', $variable));
        $response->assertSee('успех');
    }

    public function testDeleteVariable()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();

        $this->post(route('admin.tests.variables.store'), [
            'name' => 'Успех',
            'start_value' => -100.78,
            'test_id' => $test->id,
        ])
            ->assertStatus(302);
        $variable = Variable::query()->latest('id')->first();
        $this->assertDatabaseHas('variables', [
            'id' => $variable->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.tests.variables.destroy', $variable));
        $this->assertSoftDeleted('variables', [
            'id' => $variable->id,
            'deleted_at' => now(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Переменная удалена');
        $response = $this->get(route('admin.tests.variables.show', $variable));
        $response->assertStatus(404);
    }

    public function testRestoreVariable()
    {
        $this->loginByAdmin();

        $deleteVariable = Variable::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->get(route('admin.tests.variables.show', $deleteVariable->id))
            ->assertStatus(404);
        $this->assertSoftDeleted('variables', [
            'id' => $deleteVariable->id,
        ]);

        $response = $this->post(route('admin.tests.variables.restore', $deleteVariable->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Переменная восстановлена');
        $this->assertDatabaseHas('variables', [
            'id' => $deleteVariable->id,
            'deleted_at' => null,
        ]);
        $this->get(route('admin.tests.variables.show', $deleteVariable->id))
            ->assertStatus(200);
    }

    public function testPageShowOnlyTrashedVariable()
    {
        $this->loginByAdmin();
        Test::factory()->create();
        $test = Test::query()->latest('id')->first();
        $response = $this->get(route('admin.tests.show', $test));
        $response->assertStatus(200);
        $deleteVariable = Variable::factory()->create([
            'name' => 'Удаленная переменная',
            'deleted_at' => now(),
        ]);
        $response = $this->get(route('admin.tests.show', [
            'test' => $test->id,
            'deleted_variables' => true,
        ]));
        $response->assertStatus(200);
        $this->get(route('admin.tests.variables.show', $deleteVariable->id))
            ->assertStatus(404);
    }
}
