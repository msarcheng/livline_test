<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [];

        for ($i = 0; $i < 50; $i++) {
            Task::create([
                'title' => fake()->text(43),
                'description' => fake()->text(255),
            ]);
        }
    }
}
