<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\Admin::factory(20)->create();
        \App\Models\Project::factory(20)->create();
        \App\Models\Evaluation::factory(20)->create();
        \App\Models\Evaluator::factory(20)->create();
        \App\Models\Fyp_group::factory(20)->create();
        \App\Models\Location::factory(10)->create();
    }
}
