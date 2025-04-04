<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketCheckInTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_allows_successful_check_in_with_valid_ticket()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_unique_code' => 'ABC123',
            'checked_in' => false,
        ]);

        $response = $this->postJson('/api/v1/check-in', [
            'ticket_unique_code' => 'ABC123',
        ]);
        
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Check-in successful',
        ]);

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'checked_in' => true,
        ]);
    }

public function test_it_prevents_check_in_if_ticket_already_used()
{
    $user = User::factory()->create();
    $event = Event::factory()->create();

    $ticket = Ticket::factory()->create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'ticket_unique_code' => 'USED123',
        'checked_in' => true,
    ]);

    $response = $this->postJson('/api/v1/check-in', [
        'ticket_unique_code' => 'USED123',
    ]);

    $response->assertStatus(400);
    $response->assertJson([
        'message' => 'Ticket already used',
    ]);
}

}
