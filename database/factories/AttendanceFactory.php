<?php

namespace Database\Factories;

use App\Models\Attendee;
use App\Models\EventSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'check_in_time' => fake()->dateTimeThisYear(),
            'event_session_id' => EventSession::factory(),
            'validated_by_user_id' => User::factory(),
            'attendee_id' => Attendee::factory(),
        ];
    }
}
