<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewPurchasedEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_only_see_their_purchased_events()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $event1 = Event::factory()->create(['name' => 'Evento A']);
        $event2 = Event::factory()->create(['name' => 'Evento B']);
        $event3 = Event::factory()->create(['name' => 'Evento C']);

        Ticket::factory()->create([
            'user_id' => $userA->id,
            'event_id' => $event1->id,
        ]);

        Ticket::factory()->create([
            'user_id' => $userA->id,
            'event_id' => $event2->id,
        ]);

        Ticket::factory()->create([
            'user_id' => $userB->id,
            'event_id' => $event3->id,
        ]);

        $response = $this->actingAs($userA)->getJson(route('user.events.purchased'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Event A']);
        $response->assertJsonFragment(['name' => 'Event B']);
        $response->assertJsonMissing(['name' => 'Event C']);
    }
}
