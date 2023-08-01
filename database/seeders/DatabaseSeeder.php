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
        \App\Models\Year::factory(1)->create();
        \App\Models\Goal::factory(1)->create();
        \App\Models\Parameter::factory(1)->create();
        \App\Models\Client::factory(10)->create();
        \App\Models\Order::factory(30)->create();
        \App\Models\Observation::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
