<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CustomAudit;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenPageAudit()
    {
        $this->loginByAdmin();
        $response = $this->get(route('admin.audits.index'));
        $response->assertStatus(200);
    }

    public function testFilterEvents()
    {
        $this->loginByAdmin();

        $audit1 = CustomAudit::factory()->create([
            'event' => trim(CustomAudit::EVENT_CREATED),
        ]);
        $audit2 = CustomAudit::factory()->create([
            'event' => trim(CustomAudit::EVENT_RESTORED),
        ]);
        $audit3 = CustomAudit::factory()->create([
            'event' => trim(CustomAudit::EVENT_UPDATED),
        ]);

        $response = $this->get(
            route('admin.audits.index', [
                'events' => [CustomAudit::EVENT_CREATED],
                'startDate' => now()
                    ->subMonth()
                    ->format('Y-m-d'),
                'endDate' => now()
                    ->format('Y-m-d'),
            ]),
            [
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        );
        $response->assertStatus(200);
        $response->assertSee($audit1->event);
        $response->assertJsonCount(1, 'data');

    }

    public function testFilterModels()
    {
        $this->loginByAdmin();

        $audit1 = CustomAudit::factory()->create([
            'auditable_type' => Test::class,
        ]);
        $audit2 = CustomAudit::factory()->create([
            'auditable_type' => User::class,
        ]);
        $audit3 = CustomAudit::factory()->create([
            'auditable_type' => Question::class,
        ]);
        $response = $this->get(
            route('admin.audits.index', [
                'models' => [Test::class],
                'startDate' => now()
                    ->subMonth()
                    ->format('Y-m-d'),
                'endDate' => now()
                    ->format('Y-m-d'),
            ]),
            [
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        );
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'auditable_type' => Test::class,
        ]);
        $response->assertJsonCount(1, 'data');
    }

    public function testFilterUsers()
    {
        $this->loginByAdmin();

        $user1 = User::factory()->create([
            'name' => 'Ivan',
        ]);
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        $audit1 = CustomAudit::factory()->create([
            'user_id' => $user1->id,
        ]);
        $audit2 = CustomAudit::factory()->create([
            'user_id' => $user2->id,
        ]);
        $audit3 = CustomAudit::factory()->create([
            'user_id' => $user3->id,
        ]);

        $response = $this->get(
            route('admin.audits.index', [
                'users' => [$user1->id],
                'startDate' => now()
                    ->subMonth()
                    ->format('Y-m-d'),
                'endDate' => now()
                    ->format('Y-m-d'),
            ]),
            [
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        );
        $response->assertStatus(200);
        $response->assertSee($audit1->user->name);
        $response->assertJsonCount(1, 'data');
    }
}
