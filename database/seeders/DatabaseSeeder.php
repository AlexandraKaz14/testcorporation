<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\CustomAudit;
use App\Models\Group;
use App\Models\Question;
use App\Models\Result;
use App\Models\Tag;
use App\Models\TakingTest;
use App\Models\Test;
use App\Models\Theme;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Variable;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(60)->create();
        Tag::factory(4)->create();
        Category::factory(2)->create();
        Test::factory(10)->create();
        Question::factory(10)->create();
        Variable::factory(20)->create();
        Answer::factory(20)->create();
        Result::factory(10)->create();
        Theme::factory(10)->create();
        TakingTest::factory(10)->create();
    }
}
