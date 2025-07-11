<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testOpenPageGroups(): void
    {
        $this->loginByAdmin();
        $group1 = Group::factory()->create([
            'title' => 'первая подборка',
        ]);
        $group2 = Group::factory()->create([
            'title' => 'вторая подборка',
        ]);
        $group3 = Group::factory()->create([
            'title' => 'третья подборка',
        ]);
        $response = $this->get(
            route(
                'admin.groups.index'
            ),
            [
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        );
        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');

    }

    public function testPageCreate()
    {
        $this->loginByAdmin();
        $response = $this->get(route(
            'admin.groups.index'
        ));
        $response->assertStatus(200);
        $this->get(route(
            'admin.groups.create'
        ))->assertStatus(200);
    }

    public function testStoreGroup()
    {
        $this->loginByAdmin();

        $tests = Test::factory()->count(5)->create();

        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('admin.groups.store'), [
            'title' => 'Новая подборка',
            'slug' => 'new-group',
            'description' => 'описание подборки',
            'picture' => $file1,
            'tests' => $tests->pluck('id')
                ->toArray(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка создана');
        $this->assertDatabaseHas('groups', [
            'title' => 'Новая подборка',
        ]);

    }

    public function testShowGroup()
    {
        $this->loginByAdmin();

        $tests = Test::factory()->count(5)->create();

        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('admin.groups.store'), [
            'title' => 'Новая подборка',
            'slug' => 'new-group',
            'description' => 'описание подборки',
            'picture' => $file1,
            'tests' => $tests->pluck('id')
                ->toArray(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка создана');
        $this->assertDatabaseHas('groups', [
            'title' => 'Новая подборка',
        ]);
        $group = Group::query()->latest('id')->first();
        $response = $this->get(route('admin.groups.show', $group));
        $response->assertSee('Новая подборка');
    }

    public function testOpenEditPage()
    {
        $this->loginByAdmin();

        $tests = Test::factory()->count(5)->create();

        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('admin.groups.store'), [
            'title' => 'Новая подборка',
            'slug' => 'new-group',
            'description' => 'описание подборки',
            'picture' => $file1,
            'tests' => $tests->pluck('id')
                ->toArray(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка создана');
        $this->assertDatabaseHas('groups', [
            'title' => 'Новая подборка',
        ]);
        $group = Group::query()->latest('id')->first();
        $response = $this->get(route('admin.groups.edit', $group));
        $response->assertStatus(200);
    }

    public function testUpdateGroup()
    {
        $this->loginByAdmin();

        $tests = Test::factory()->count(5)->create();

        Storage::fake('public');
        $file1 = UploadedFile::fake()->image('test2.jpg');

        $response = $this->post(route('admin.groups.store'), [
            'title' => 'Подборка фильмы',
            'slug' => 'new-group',
            'description' => 'описание подборки',
            'picture' => $file1,
            'tests' => $tests->pluck('id')
                ->toArray(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка создана');

        $group = Group::query()->latest('id')->first();
        $response = $this->get(route('admin.groups.edit', $group));
        $response->assertStatus(200);
        $response->assertSee('Тест');
        $response = $this->patch(route('admin.groups.update', $group), [
            'title' => 'Подборка фильмы и сериалы',
            'slug' => 'new-group-serials',
            'description' => 'описание подборки',
            'picture' => $file1,
            'tests' => $tests->pluck('id')
                ->toArray(),
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка обновлена');

    }

    public function testDeleteGroup()
    {
        $this->loginByAdmin();
        Group::factory()->create();
        $group = Group::query()->latest('id')->first();
        $response = $this->delete(route('admin.groups.destroy', $group));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка удалена');
        $response = $this->get(route('admin.groups.show', $group));
        $response->assertStatus(404);
    }

    public function testRestoreGroup()
    {
        $this->loginByAdmin();

        $deleteGroup = Group::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->get(route('admin.groups.show', $deleteGroup->id))
            ->assertStatus(404);
        $this->assertSoftDeleted('groups', [
            'id' => $deleteGroup->id,
        ]);

        $response = $this->post(route('admin.groups.restore', $deleteGroup->id));
        $response->assertStatus(302);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Подборка восстановлена');

        $this->assertDatabaseHas('groups', [
            'id' => $deleteGroup->id,
            'deleted_at' => null,
        ]);
        $this->get(route('admin.tests.show', $deleteGroup->id))
            ->assertStatus(200);
    }
}
