<?php

namespace Database\Factories;

use App\Models\TicketType;
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
            'ticket_type_id' => TicketType::factory(),
            'ticket_unique_code' => fake() -> unique() -> numerify('TKT########'),
            'purchase_date' => fake() -> dateTimeBetween('-1 year', 'now'),
            'checked_in' => fake() -> boolean(),
        ];
    }
}
