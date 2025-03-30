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
        return [
            'name' => $this->fake()->name(),
            'price' => $this->fake()->randomFloat(2, 200),
            'quantity_available' => $this->fake()->randomNumber(2, 100),
            'sales_start' => $this->fake()->dateTime(),
            'sales_end' => $this->fake()->dateTime(),
        ];
    }
}
