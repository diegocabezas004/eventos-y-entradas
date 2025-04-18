<?php

namespace Database\Factories;

use App\Models\EventCategory;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('+1 month', '+6 months');
        $endDate = clone $startDate;
        $endDate->modify('+' . rand(1, 5) . ' days');

        return [
            'name' => fake()->sentence(3),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => fake()->address(),
            'capacity' => fake()->numberBetween(50, 2000),
            'organization_id' => Organization::factory(),
            'category_id' => EventCategory::factory(),
        ];
    }
}
