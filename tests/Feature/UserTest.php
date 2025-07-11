<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->faker->unique(true);
    }

    public function testPageOnView()
    {
        $user = User::factory()->create();
        $this->loginByAdmin();
        $this->get(route('admin.users.show', $user))
            ->assertStatus(200)
            ->assertSeeText($user->email);
        $deletedUser = User::factory()->create([
            'deleted_at' => now(),
        ]);
        $this->get(route('admin.users.show', $deletedUser))
            ->assertStatus(404);
    }

    public function testStore()
    {
        $this->loginByAdmin();
        $response = $this->post(route('admin.users.store'), [
            'name' => 'Ivan',
            'email' => 'ivan@gmail.com',
            'password' => '1274522errt',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $user = User::query()->latest('id')->first();
        $response->assertLocation(route('admin.users.show', $user));
        $this->followRedirects($response)
            ->assertSeeText('ivan@gmail.com');
    }

    public function testInvalidPasswordStore()
    {
        $this->loginByAdmin();
        $this->get(route('admin.users.index'));
        $response = $this->post(route('admin.users.store'), [
            'name' => 'Ivan',
            'email' => 'ivan@gmail.com',
            'password' => '12767895d',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $user = User::query()->latest('id')->first();
        $response->assertLocation(route('admin.users.show', $user));
        $this->followRedirects($response)
            ->assertSeeText('ivan@gmail.com');
    }

    public function testDeleted()
    {
        $this->loginByAdmin();
        $this->get(route('admin.users.index'));
        $this->post(route('admin.users.store'), [
            'name' => 'Ivan Deleted',
            'email' => 'ivan@gmail.com',
            'password' => '123456789',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $user = User::query()->latest('id')->first();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
        $response = $this->delete(route('admin.users.destroy', $user));
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Пользователь удален');
        $response = $this->get(route('admin.users.show', $user));
        $response->assertStatus(404);
    }

    public function testPageEdit()
    {
        $this->loginByAdmin();
        $this->get(route('admin.users.index'));
        $this->post(route('admin.users.store'), [
            'name' => 'Ivan Edit',
            'email' => 'ivanedit@gmail.com',
            'password' => '123456789t',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $user = User::query()->latest('id')->first();
        $response = $this->get(route('admin.users.edit', $user));
        $response->assertStatus(200);
        $response->assertSee('Ivan Edit');
        $response->assertSee('ivanedit@gmail.com');
        $response->assertSee(User::ROLE_ADMIN);
    }

    public function testUpdate()
    {
        $this->loginByAdmin();
        $this->post(route('admin.users.store'), [
            'name' => 'Ivan Update',
            'email' => 'ivan_update@gmail.com',
            'password' => '123456789te',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $user = User::query()->latest('id')->first();
        $response = $this->get(route('admin.users.edit', $user));
        $response->assertStatus(200);
        $this->patch(route('admin.users.update', $user), [
            'name' => 'Update Update',
            'email' => 'ivan_update111@gmail.com',
            'password' => '123456789te',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $response = $this->get(route('admin.users.show', $user));
        $response->assertSee('Update Update');
        $response->assertSee('ivan_update111@gmail.com');
        $this->assertDatabaseHas('users', [
            'email' => 'ivan_update111@gmail.com',
        ]);
    }

    public function testRestore()
    {
        $this->loginByAdmin();
        $deletedUser = User::factory()->create([
            'deleted_at' => now(),
        ]);
        $this->get(route('admin.users.show', $deletedUser->id))
            ->assertStatus(404);
        $this->assertSoftDeleted('users', [
            'id' => $deletedUser->id,
        ]);
        $response = $this->post(route('admin.users.restore', $deletedUser->id));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Пользователь восстановлен');
        $this->assertDatabaseHas('users', [
            'id' => $deletedUser->id,
            'deleted_at' => null,
        ]);
        $this->get(route('admin.users.show', $deletedUser->id))
            ->assertStatus(200);
    }

    public function testFiltersByStatusAndRole()
    {
        $adminActive = User::factory()->create([
            'name' => 'Sascha',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $adminBlocked = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_BLOCKED,
        ]);

        $moderatorActive = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
            'status' => User::STATUS_ACTIVE,
        ]);
        $moderatorBlocked = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
            'status' => User::STATUS_BLOCKED,
        ]);

        $authorActive = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'status' => User::STATUS_ACTIVE,
        ]);

        $this->loginByAdmin();

        $response = $this->get(route('admin.users.index', [
            'roles' => [User::ROLE_ADMIN],
            'statuses' => [User::STATUS_ACTIVE],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertSee($adminActive->name);
        $response->assertDontSee($moderatorBlocked->name);

    }

    public function testUsersPage()
    {
        $this->loginByAdmin();
        $response = $this->get(route(
            'admin.users.index',
            [
                'daterange' => '2000-01-01/2025-09-04',
            ]
        ));
        $response->assertStatus(302);
    }

    public function testCreate()
    {
        $this->loginByAdmin();
        $response = $this->get(route('admin.users.index'))
            ->assertStatus(200);
        $response = $this->get(route('admin.users.create'))
            ->assertStatus(200);
        $user = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'status' => User::STATUS_ACTIVE,
        ]);
        $response->assertStatus(200);
    }

    public function testWithoutPasswordUpdate()
    {
        $this->loginByAdmin();
        $this->post(route('admin.users.store'), [
            'name' => 'User Name',
            'email' => 'user_name@gmail.com',
            'password' => 'password1234',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ])
            ->assertStatus(302);
        $user = User::query()->latest('id')->first();
        $response = $this->get(route('admin.users.edit', $user));
        $response->assertStatus(200);
        $response = $this->patch(route('admin.users.update', $user), [
            'name' => 'User Update',
            'email' => 'user_update111@gmail.com',
            'password' => null,
            'role' => User::ROLE_AUTHOR,
            'status' => User::STATUS_ACTIVE,
        ]);
        $response->assertRedirect()
            ->assertSessionHas('success', 'Пользователь обновлен');
        $response = $this->get(route('admin.users.show', $user));
        $response->assertSee('User Update');
        $response->assertSee('user_update111@gmail.com');
        $this->assertDatabaseHas('users', [
            'name' => 'User Update',
            'email' => 'user_update111@gmail.com',
        ]);
    }

    public function testFilterTwoRolesAndStatuses()
    {
        $adminActive = User::factory()->create([
            'name' => 'Sascha',
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $adminBlocked = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_BLOCKED,
        ]);

        $moderatorActive = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
            'status' => User::STATUS_ACTIVE,
        ]);
        $moderatorBlocked = User::factory()->create([
            'role' => User::ROLE_MODERATOR,
            'status' => User::STATUS_BLOCKED,
        ]);

        $authorActive = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'status' => User::STATUS_ACTIVE,
        ]);
        $authorBlocked = User::factory()->create([
            'role' => User::ROLE_AUTHOR,
            'status' => User::STATUS_BLOCKED,
        ]);

        $this->loginByAdmin();

        $response = $this->get(route('admin.users.index', [
            'roles' => [User::ROLE_ADMIN, User::ROLE_AUTHOR],
            'statuses' => [User::STATUS_ACTIVE, User::STATUS_BLOCKED],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        $response->assertStatus(200);
        $response->assertSee($adminActive->name);
        $response->assertSee($authorActive->name);
        $response->assertSee($adminBlocked->name);
        $response->assertSee($authorBlocked->name);
        $response->assertDontSee($moderatorBlocked->name);
        $response->assertDontSee($moderatorActive->name);

    }

    public function testFilterUndeletedUsers()
    {
        $undeletedUser = User::factory()->create([
            'name' => 'Live User',
        ]);
        $deletedUser = User::factory()->create([
            'name' => 'Deleted User',
            'deleted_at' => now(),
        ]);

        $this->loginByAdmin();

        $response = $this->get(route('admin.users.index', [
            'deletedStatuses' => [User::DELETED_STATUS_LIVE],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $response->assertStatus(200);
        $response->assertSee($undeletedUser->name);
        $response->assertDontSee($deletedUser->name);
    }

    public function testFilterDeletedUsers()
    {
        $undeletedUser = User::factory()->create();
        $deletedUser = User::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->loginByAdmin();

        $response = $this->get(route('admin.users.index', [
            'deletedStatuses' => [User::DELETED_STATUS_TRASHED],
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $response->assertStatus(200);
        $response->assertSee($deletedUser->name);
        $response->assertDontSee($undeletedUser->name);

    }

    public function testFilterDataRegistration()
    {
        $createdAtTimes = [
            '2024-09-08 09:00:00',
            '2024-09-05 12:00:00',
            '2024-09-05 13:00:00',
            now(),
        ];
        $users = [];
        foreach ($createdAtTimes as $createdAt) {
            $users[] = User::factory()->create([
                'created_at' => $createdAt,
            ]);
        }

        $users[] = $this->loginByAdmin();
        $response = $this->get(route('admin.users.index', [
            'daterange' => '2024-09-05 - 2024-09-06',
        ]), [
            'Accept' => 'application/json, text/javascript, */*; q=0.01',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
        $response->assertStatus(200);
        $response->assertDontSee($users[0]->email);
        $response->assertSee($users[1]->email);
        $response->assertSee($users[2]->email);
        $response->assertDontSee($users[3]->email);
        $response->assertDontSee($users[4]->email);
    }

    public function testLoginAsUser()
    {
        $this->loginByAdmin();

        $undeletedUser = User::factory()->create([
            'name' => 'Live User',
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->get(route('admin.users.login_as_user', $undeletedUser));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Вы вошли под пользователем: ' . $undeletedUser->name);
    }

    public function testLoginAsBlockedUser()
    {
        $this->loginByAdmin();

        $blockedUser = User::factory()->create([
            'name' => 'Blocked User',
            'status' => User::STATUS_BLOCKED,
        ]);
        $response = $this->get(route('admin.users.login_as_user', $blockedUser));
        $response->assertRedirect();
    }
}
