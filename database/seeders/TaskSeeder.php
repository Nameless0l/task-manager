<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Task::factory()->create([
            'id' => fake()->randomNumber(),
            'title' => fake()->word(),
            'status' => fake()->word()
        ]);
    }
}
