<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\SendDailyStatisticsJob;
use App\Models\TakingTest;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SendDailyStatisticsJobTest extends TestCase
{
    use RefreshDatabase;

    public function testDailyStatisticsJobSendsMessage()
    {
        $mockTelegram = $this->mock(\NotificationChannels\Telegram\TelegramChannel::class);
        $mockTelegram->shouldReceive('send')
            ->once();

        $yesterday = Carbon::yesterday();
        Carbon::setTestNow($yesterday->copy()->addDay());

        User::factory()->count(3)->create([
            'created_at' => $yesterday,
        ]);
        Test::factory()->count(5)->create([
            'created_at' => $yesterday,
        ]);
        Test::factory()->count(2)->create([
            'created_at' => $yesterday,
            'status' => Test::STATUS_ACTIVE,
        ]);
        TakingTest::factory()->count(7)->create([
            'created_at' => $yesterday,
            'is_temporary' => false,
        ]);
        $job = new SendDailyStatisticsJob();
        $job->handle();

        $mockTelegram->shouldHaveReceived('send');
    }
}
