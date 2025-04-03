<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_all_events()
    {
        Event::factory()->create(['name' => 'Music Festival']);
        Event::factory()->create(['name' => 'Tech Conference']);
        Event::factory()->create(['name' => 'Cooking Workshop']);

        $response = $this->getJson(route('events.index'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Music Festival']);
        $response->assertJsonFragment(['name' => 'Tech Conference']);
        $response->assertJsonFragment(['name' => 'Cooking Workshop']);
    }
}
