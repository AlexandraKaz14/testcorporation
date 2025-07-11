<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenPageIndexThemes(): void
    {
        $this->loginByAdmin();
        $response = $this->get(route(
            'admin.themes.index'
        ));
        $response->assertStatus(200);
    }

    public function testPageCreate()
    {
        $this->loginByAdmin();
        $response = $this->get(route(
            'admin.themes.index'
        ));
        $response->assertStatus(200);
        $this->get(route(
            'admin.themes.create'
        ))->assertStatus(200);
    }

    public function testStoreTheme()
    {
        $this->loginByAdmin();
        $response = $this->post(route('admin.themes.store'), [
            'title' => 'Тема по умолчанию',
            'css_style' => 'код',
        ])
            ->assertStatus(302);
        $this->assertDatabaseHas('themes', [
            'title' => 'Тема по умолчанию',
        ]);
        $theme = Theme::query()->latest('id')->first();
        $response->assertLocation(route('admin.themes.show', $theme));
        $this->followRedirects($response)
            ->assertSeeText('Тема по умолчанию');
    }

    public function testPageEditTheme()
    {
        $this->loginByAdmin();
        $this->post(route('admin.themes.store'), [
            'title' => 'Тема светлая',
            'css_style' => 'padding-bottom: 50px;',
        ])
            ->assertRedirect()
            ->assertSessionHas('success', 'Тема добавлена');
        $theme = Theme::query()->latest('id')->first();
        $response = $this->get(route(
            'admin.themes.edit',
            $theme
        ));
        $response->assertStatus(200);
        $response->assertSee('Тема светлая');
    }

    public function testUpdateTheme()
    {
        $this->loginByAdmin();
        $this->post(route('admin.themes.store'), [
            'title' => 'Тема светлая',
            'css_style' => 'padding-bottom: 50px;',
        ])
            ->assertStatus(302);
        $theme = Theme::query()->latest('id')->first();
        $response = $this->get(route(
            'admin.themes.edit',
            $theme
        ));
        $response->assertStatus(200);
        $this->patch(route('admin.themes.update', $theme), [
            'title' => 'Тема темная',
            'css_style' => 'padding-bottom: 50px;',
        ]) ->assertRedirect()
            ->assertSessionHas('success', 'Тема обновлена');
        $this->assertDatabaseHas('themes', [
            'title' => 'Тема темная',
        ]);
    }

    public function testDeleteTheme()
    {
        $this->loginByAdmin();
        $this->get(route('admin.themes.index'));
        $this->post(route('admin.themes.store'), [
            'title' => 'Тема темная',
            'css_style' => 'padding-bottom: 50px;',
        ])
            ->assertStatus(302);
        $theme = Theme::query()->latest('id')->first();
        $this->assertDatabaseHas('themes', [
            'id' => $theme->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.themes.destroy', $theme));
        $this->assertSoftDeleted('themes', [
            'id' => $theme->id,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Тема удалена');
        $response = $this->get(route('admin.themes.show', $theme));
        $response->assertStatus(404);
    }

    public function testRequiredTitleTheme()
    {
        $this->loginByAdmin();
        $response = $this->post(route('admin.themes.store'), [
            'title' => null,
            'css_style' => 'color: black',
        ]);
        $response->assertSessionHasErrors(['title']);
    }

    public function testIndexTheme()
    {
        $this->loginByAdmin();

        Theme::factory()->create([
            'title' => 'Theme 1',
        ]);
        Theme::factory()->create([
            'title' => 'Theme 2',
        ]);

        $response = $this->get(route('admin.themes.index'), [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);

    }
}
