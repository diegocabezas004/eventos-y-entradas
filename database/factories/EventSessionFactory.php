<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventSession>
 */
class EventSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('+1 week', '+1 month');
        $endTime = clone $startTime;
        $endTime->modify('+' . rand(30, 180) . ' minutes');

        return [
            'name' => fake() -> sentence(3),
            'event_id' => Event::factory(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'location' => fake() -> streetAddress(),
         ];
    }
}
