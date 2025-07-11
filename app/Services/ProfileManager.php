<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\TakingTest;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProfileManager
{
    public function getProfileData(User $user): array
    {
        $totalPassings = $this->getTotalPassings($user);
        $mountPassings = $this->getPassingsForCurrentMonth($user);
        $lastMountPassings = $this->getPassingsForLastMonth($user);
        $weekPassings = $this->getPassingsForLastWeek($user);
        $dayPassings = $this->getPassingsForLastDay($user);
        $popularTests = $this->getPopularTests($user);
        $topUsers = $this->getTopUsers($user);
        $percentageChange = $this->calculatePercentageChange($mountPassings, $lastMountPassings);
        $chartData = $this->getChartData($user);

        return array_merge($chartData, [
            'totalPassings' => $totalPassings,
            'mountPassings' => $mountPassings,
            'weekPassings' => $weekPassings,
            'dayPassings' => $dayPassings,
            'popularTests' => $popularTests,
            'topUsers' => $topUsers,
            'lastMountPassings' => $lastMountPassings,
            'percentageChange' => $percentageChange,
            'user' => $user,
        ]);
    }

    protected function getTotalPassings(User $user): int
    {
        return (int) Cache::remember("user:{$user->id}:totalPassings", 3600, function () use ($user) {
            return TakingTest::whereIn('test_id', $user->tests->pluck('id'))->count();
        });
    }

    protected function getPassingsForCurrentMonth(User $user): int
    {
        $startOfMonth = Carbon::now()->subMonth();
        $endOfMonth = Carbon::now();
        return (int) Cache::remember("user:{$user->id}:mountPassings", 3600, function () use ($user, $startOfMonth, $endOfMonth) {
            return TakingTest::whereIn('test_id', $user->tests->pluck('id'))
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        });

    }

    protected function getPassingsForLastMonth(User $user): int
    {
        $previousStartDate = Carbon::now()->subDays(60);
        $previousEndDate = Carbon::now()->subDays(31);
        return (int) Cache::remember("user:{$user->id}:lastMountPassings", 3600, function () use ($user, $previousStartDate, $previousEndDate) {
            return TakingTest::whereIn('test_id', $user->tests->pluck('id'))
                ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
                ->count();
        });
    }

    protected function getPassingsForLastWeek(User $user): int
    {
        $sevenDaysAgo = Carbon::now()->subWeek();
        $currentDay = Carbon::now();

        return (int) Cache::remember("user:{$user->id}:weekPassings", 3600, function () use ($user, $sevenDaysAgo, $currentDay) {
            return TakingTest::whereIn('test_id', $user->tests->pluck('id'))
                ->whereBetween('created_at', [$sevenDaysAgo, $currentDay])
                ->count();
        });
    }

    protected function getPassingsForLastDay(User $user): int
    {
        $last24Hours = Carbon::now()->subDay();

        return (int) Cache::remember("user:{$user->id}:dayPassings", 3600, function () use ($user, $last24Hours) {
            return TakingTest::whereIn('test_id', $user->tests->pluck('id'))
                ->where('created_at', '>=', $last24Hours)
                ->count();
        });
    }

    protected function getPopularTests(User $user)
    {
        return Cache::remember('popular_tests_user_' . $user->id, 3600, function () use ($user) {
            return TakingTest::select('tests.title', DB::raw('COUNT(taking_tests.id) as total_passages'))
                ->join('tests', 'taking_tests.test_id', '=', 'tests.id')
                ->whereIn('taking_tests.test_id', $user->tests->pluck('id'))
                ->groupBy('tests.id', 'tests.title')
                ->orderByDesc('total_passages')
                ->limit(3)
                ->get();
        });

    }

    protected function getTopUsers(User $user)
    {
        $sql = <<<SQL
WITH source as (
select user_id,
       max(case when date = now()::date then rank end) as rank_today,
       max(case when date = ((now() - interval '1 day')::date) then rank end) as rank_yesterday,
    max(case when date = now()::date then points end) as points_today,
        max(case when date = ((now() - interval '1 day')::date) then points end) as points_yesterday
from ratings
where (date = now()::date or date = (now() - interval '1 day')::date)
  and (user_id in (select user_id
                   from ratings
                   where date = now()::date
                   order by points desc
                   limit 3) or user_id = ?
    )
group by user_id)

select users.name, points_today, coalesce(points_today-points_yesterday,0) as points_change, rank_today, coalesce(rank_yesterday-rank_today,0) as rank_change from source
left join users on users.id = source.user_id
order by rank_today
SQL;
        return Cache::remember('top_users_' . auth()->id(), 3600, function () use ($sql) {
            return DB::select($sql, [auth()->id()]);
        });

    }

    protected function calculatePercentageChange(int $current, int $previous): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }
        return (($current - $previous) / $previous) * 100;
    }

    protected function getChartData(User $user): array
    {
        return Cache::remember('user_taking_tests_' . $user->id, 3600, function () use ($user) {
            $startOfMonth = Carbon::now()->subMonth();
            $endOfMonth = Carbon::now();
            $previousStartDate = Carbon::now()->subDays(60);
            $previousEndDate = Carbon::now()->subDays(31);

            $data = DB::table('taking_tests')
                ->join('tests', 'taking_tests.test_id', '=', 'tests.id')
                ->where('tests.user_id', $user->id)
                ->where(function ($query) use ($startOfMonth, $endOfMonth, $previousStartDate, $previousEndDate) {
                    $query->whereBetween('taking_tests.created_at', [$startOfMonth, $endOfMonth])
                        ->orWhereBetween('taking_tests.created_at', [$previousStartDate, $previousEndDate]);
                })
                ->select(
                    DB::raw('DATE(taking_tests.created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $currentRange = collect();
            $previousRange = collect();

            for ($i = 0; $i <= 30; $i++) {
                $currentRange->push($startOfMonth->copy()->addDays($i)->toDateString());
                $previousRange->push($previousStartDate->copy()->addDays($i)->toDateString());
            }

            $dataByDate = $data->keyBy('date');

            $currentData = $currentRange->mapWithKeys(function ($date) use ($dataByDate) {
                return [
                    $date => isset($dataByDate[$date]) ? $dataByDate[$date]->count : 0,
                ];
            });

            $previousData = $previousRange->mapWithKeys(function ($date) use ($dataByDate) {
                return [
                    $date => isset($dataByDate[$date]) ? $dataByDate[$date]->count : 0,
                ];
            });

            return [
                'currentLabels' => $currentData->keys()
                    ->toArray(),
                'currentValues' => $currentData->values()
                    ->toArray(),
                'previousLabels' => $previousData->keys()
                    ->toArray(),
                'previousValues' => $previousData->values()
                    ->toArray(),
            ];
        });
    }
}
