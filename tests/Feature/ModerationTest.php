<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Moderation;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenPageTests()
    {
        $this->loginByAdmin();
        $response = $this->get(route('admin.moderations.index'));
        $response->assertStatus(200);
    }

    public function testApprovedModeration()
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $test = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);

        $moderation = Moderation::factory()->create([
            'test_id' => $test->id,
            'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
            'moderator_id' => null,
            'moderation_at' => null,
        ]);
        $response = $this->actingAs($admin)
            ->post(route('admin.moderations.approved', [
                'moderation' => $moderation,
            ]));
        $response->assertRedirect()
            ->assertSessionHas('success', 'Модерация пройдена, тест успешно опубликован, уведомление отправлено автору теста');

        $this->assertDatabaseHas('moderation_tests', [
            'test_id' => $test->id,
            'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
            'moderator_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'status' => Test::STATUS_ACTIVE,
        ]);
        $freshModeration = $moderation->fresh();
        $this->assertNotNull($freshModeration->moderation_at);

        $this->assertEquals(
            now()
                ->format('Y-m-d H:i'),
            $freshModeration->moderation_at->format('Y-m-d H:i')
        );
    }

    public function testRejectedModeration()
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,

        ]);
        $test = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);

        $moderation = Moderation::factory()->create([
            'test_id' => $test->id,
            'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
            'rejection_reason' => null,
            'moderator_id' => null,
            'moderation_at' => null,
        ]);
        $requestData = [
            'rejection_reason' => 'Тест не принят',
        ];

        $response = $this->actingAs($admin)
            ->post(
                route('admin.moderations.rejected', [
                    'moderation' => $moderation,
                ]),
                $requestData
            );
        $response->assertRedirect(route('admin.moderations.index', $moderation))
            ->assertSessionHas('success', 'Модерация теста не пройдена, отправлено уведомление автору теста');

        $this->assertDatabaseHas('moderation_tests', [
            'test_id' => $test->id,
            'moderation_status' => Moderation::MODERATION_STATUS_REJECTED,
            'rejection_reason' => 'Тест не принят',
            'moderator_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('tests', [
            'id' => $test->id,
            'status' => Test::STATUS_DRAFT,
        ]);
        $this->assertNotNull($moderation->fresh()->moderation_at);

    }

    public function testFilterStatusModeration()
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $test1 = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $test2 = Test::factory()->create([
            'status' => Test::STATUS_ACTIVE,
        ]);
        $test3 = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $moderation1 = Moderation::factory()->create([
            'test_id' => $test1->id,
            'moderation_status' => Moderation::MODERATION_STATUS_PENDING,
        ]);
        $moderation2 = Moderation::factory()->create([
            'test_id' => $test2->id,
            'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
            'moderator_id' => $admin->id,
        ]);
        $moderation3 = Moderation::factory()->create([
            'test_id' => $test3->id,
            'moderation_status' => Moderation::MODERATION_STATUS_REJECTED,
            'moderator_id' => $admin->id,
        ]);

        $response = $this->actingAs($admin)
            ->getJson(
                route('admin.moderations.index', [
                    'statuses' => [Moderation::MODERATION_STATUS_APPROVED],
                    'startDate' => now()
                        ->subMonth()
                        ->format('Y-m-d'),
                    'endDate' => now()
                        ->format('Y-m-d'),
                ]),
                [
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Accept' => 'application/json',
                ]
            );
        $response->assertStatus(200);
        $response->assertSee($moderation2->moderation_status);
        $response->assertDontSee($moderation1->moderation_status);
        $response->assertDontSee($moderation3->moderation_status);
    }

    public function testFilterModeratorModeration()
    {
        $admin1 = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $admin2 = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $admin3 = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $test1 = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $test2 = Test::factory()->create([
            'status' => Test::STATUS_ACTIVE,
        ]);
        $test3 = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
        ]);
        $moderation1 = Moderation::factory()->create([
            'test_id' => $test1->id,
            'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
            'moderator_id' => $admin1->id,

        ]);
        $moderation2 = Moderation::factory()->create([
            'test_id' => $test2->id,
            'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
            'moderator_id' => $admin2->id,
        ]);
        $moderation3 = Moderation::factory()->create([
            'test_id' => $test3->id,
            'moderation_status' => Moderation::MODERATION_STATUS_REJECTED,
            'moderator_id' => $admin3->id,
        ]);

        $response = $this->actingAs($admin1)
            ->getJson(
                route('admin.moderations.index', [
                    'statuses' => [Moderation::MODERATION_STATUS_APPROVED],
                    'moderators' => [$admin1->id],
                    'startDate' => now()
                        ->subMonth()
                        ->format('Y-m-d'),
                    'endDate' => now()
                        ->format('Y-m-d'),
                ]),
                [
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Accept' => 'application/json',
                ]
            );
        $response->assertStatus(200);
        $response->assertSee($moderation1->moderator_id);
        $response->assertDontSee($moderation2->moderator_id);
        $response->assertDontSee($moderation3->moderator_id);
    }

    public function testFilterAuthorTest()
    {
        $admin1 = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);
        $user1 = User::factory()->create([
            'name' => 'Ivan',
        ]);
        $user2 = User::factory()->create([
            'name' => 'Peter',
        ]);
        $test1 = Test::factory()->create([
            'status' => Test::STATUS_ACTIVE,
            'user_id' => $user1->id,
        ]);
        $test2 = Test::factory()->create([
            'status' => Test::STATUS_ACTIVE,
            'user_id' => $user2->id,
        ]);
        $test3 = Test::factory()->create([
            'status' => Test::STATUS_DRAFT,
            'user_id' => $user2->id,
        ]);

        $moderation1 = Moderation::factory()->create([
            'test_id' => $test1->id,
            'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
            'moderator_id' => $admin1->id,

        ]);
        $moderation2 = Moderation::factory()->create([
            'test_id' => $test2->id,
            'moderation_status' => Moderation::MODERATION_STATUS_APPROVED,
            'moderator_id' => $admin1->id,
        ]);
        $moderation3 = Moderation::factory()->create([
            'test_id' => $test3->id,
            'moderation_status' => Moderation::MODERATION_STATUS_REJECTED,
            'moderator_id' => $admin1->id,
        ]);

        $response = $this->actingAs($admin1)
            ->getJson(
                route('admin.moderations.index', [
                    'authors' => [$user2],
                    'startDate' => now()
                        ->subMonth()
                        ->format('Y-m-d'),
                    'endDate' => now()
                        ->format('Y-m-d'),
                ]),
                [
                    'X-Requested-With' => 'XMLHttpRequest',
                    'Accept' => 'application/json',
                ]
            );
        $response->assertStatus(200);
        $response->assertDontSee($moderation1->user_id);
        $response->assertSee($moderation2->user_id);
        $response->assertSee($moderation3->user_id);
    }
}
