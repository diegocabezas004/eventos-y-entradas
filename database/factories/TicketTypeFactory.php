<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket_Type>
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
            'name' => fake()->words(),
            'price' => fake()->randomFloat(2, 10, 500),
            'quantity_available' => fake()->numberBetween(50, 1000),
            'sales_start' => $salesStart,
            'sales_end' => $salesEnd
        ];
    }
}
