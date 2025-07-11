<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeletedTemporaryResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deleted-temporary-result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет временную запись в таблице taking_tests  каждые 5 минут';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Начинаю удаление');
        DB::table('taking_tests')->where('is_temporary', true)->delete();

    }
}
