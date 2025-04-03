<?php

namespace Tests\Feature\Events;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CreateEventWrongDatesTest extends TestCase
{
    use RefreshDatabase;

    public function test_cant_create_event_with_wrong_dates()
    {
        Sanctum::actingAs(User::factory()->create());

        $eventData = [
            'organization_id' => '1',
            'name' => 'Titulo',
            'start_date' => '30/09/2025',
            'end_date' => '28/09/2025',
            'location' => 'Sivar',
            'capacity' => '2000',
        ];

        $response = $this->postJson('/api/v1/events', $eventData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_date']);
    }
}
