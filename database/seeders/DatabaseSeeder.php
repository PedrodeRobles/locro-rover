<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Year;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Year::factory(1)->create();
        // \App\Models\Goal::factory(1)->create();
        // \App\Models\Parameter::factory(1)->create();
        // \App\Models\Client::factory(10)->create();
        // \App\Models\Order::factory(60)->create();
        // \App\Models\Observation::factory(20)->create();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'piterddr@gmail.com',
            'active' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt(12345678), // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        Year::create([
            'year'   => Carbon::now()->year,
            'active' => true
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => '8',
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);
    }
}
