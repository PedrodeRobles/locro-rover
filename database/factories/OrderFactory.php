<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id'       => rand(1, 10),
            'year_id'         => 1,
            'user_id'         => null,
            'portions'        => rand(1, 8),
            'take_away'       => rand(0, 1),
            'sauces'          => rand(1, 3),
            'amount'          => 4000,
            'money_collected' => 0,
            'to_collect'      => 4000,
            'mp'              => null,
            'last_edition'    => null,
        ];
    }
}
