<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketType>
 */
class TicketTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salesStart = fake()->dateTimeBetween('-1 month', '+1 month');
        $salesEnd = fake()->dateTimeBetween($salesStart, '+6 months');

        return [
            'name' => fake()->words(2,true),
            'event_id' => Event::factory(),
            'price' => fake()->randomFloat(2, 10, 500),
            'quantity_available' => fake()->numberBetween(50, 1000),
            'sales_start' => $salesStart,
            'sales_end' => $salesEnd
        ];
    }
}
