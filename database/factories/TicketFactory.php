<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_unique_code' => $this->fake()->unique()->randomNumber(8),
            'purchase_date' => $this->faker()->dateTime()
            'checked_in' => $this->faker()->boolean(),,

        ];
    }
}
