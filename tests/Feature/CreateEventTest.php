<?php

namespace Tests\Feature\Events;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_event_successfully()
    {
        Sanctum::actingAs(User::factory()->create());

        $payload = [
            'organization_id' => '1',
            'name' => 'Titulo',
            'start_date' => '28/09/2025',
            'end_date' => '30/09/2025',
            'location' => 'Sivar',
            'capacity' => '2000',
        ];

        $response = $this->postJson('/api/v1/events', $payload);
        $response->assertStatus(201);
    }
}
