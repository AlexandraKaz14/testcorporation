<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Расчитывает таблицу рейтинга пользователей один раз в сутки';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            // Удаляем старые записи
            DB::table('ratings')
                ->whereIn('date', [
                    DB::raw('CURRENT_DATE'), // now()::date
                    DB::raw('(CURRENT_DATE - INTERVAL \'1 day\')'), // (now() - interval '1 day')::date
                ])
                ->delete();

            // Добавляем новые записи
            $currentDayQuery = DB::table('taking_tests')
                ->join('tests', 'taking_tests.test_id', '=', 'tests.id')
                ->selectRaw('
            CURRENT_DATE as date,
            tests.user_id,
            COUNT(taking_tests.id ) filter (where is_temporary is false) as points,
            ROW_NUMBER() OVER (ORDER BY COUNT(taking_tests.id) filter (where is_temporary is false) DESC) as rank
        ')
                ->where('taking_tests.created_at', '>=', DB::raw('CURRENT_DATE - INTERVAL \'30 days\''))
                ->groupBy('tests.user_id');

            $previousDayQuery = DB::table('taking_tests')
                ->join('tests', 'taking_tests.test_id', '=', 'tests.id')
                ->selectRaw('
            (CURRENT_DATE - INTERVAL \'1 day\') as date,
            tests.user_id,
            COUNT(taking_tests.id) as points,
            ROW_NUMBER() OVER (ORDER BY COUNT(taking_tests.id) DESC) as rank
        ')
                ->whereBetween('taking_tests.created_at', [
                    DB::raw('(CURRENT_DATE - INTERVAL \'1 day\') - INTERVAL \'30 days\''),
                    DB::raw('(CURRENT_DATE - INTERVAL \'1 day\')'),
                ])
                ->groupBy('tests.user_id');

            // Объединение запросов
            $unionQuery = $currentDayQuery->unionAll($previousDayQuery);

            // Вставка новых данных
            DB::table('ratings')->insertUsing(
                ['date', 'user_id', 'points', 'rank'],
                $unionQuery
            );
        });
        $this->info('Ratings calculated successfully.');
    }
}
