<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewEventDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_event_details()
    {
        $event = Event::factory()->create([
            'name' => 'Book Fair',
            'description' => 'A fair for book lovers',
            'location' => 'Convention Center',
        ]);

        $response = $this->getJson(route('events.show', $event->id));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Book Fair',
            'description' => 'A fair for book lovers',
            'location' => 'Convention Center',
        ]);
    }
}
