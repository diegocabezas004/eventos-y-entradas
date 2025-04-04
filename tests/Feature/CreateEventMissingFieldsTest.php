<?php

namespace Tests\Feature\Events;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CreateEventMissingFieldsTest extends TestCase
{
    use RefreshDatabase;
    public function test_cant_create_event_with_missing_fields()
    {
        $user = User::factory()->create(['role_id' => 1]);
        $this->actingAs($user);
    
        $eventData = [
            'organization_id' => '1',
            'name' => 'Cash_inc',
            'start_date' => '28/09/2025',
            'end_date' => '30/09/2025',
            'location' => 'Sivar',
        ];
    
        $response = $this->postJson('/api/v1/events', $eventData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['capacity']);
    }
    
}
