<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_filters_events_by_category()
    {
        $music = EventCategory::factory()->create(['category' => 'Music']);
        $tech = EventCategory::factory()->create(['category' => 'Technology']);

        Event::factory()->create(['category' => 'Concert', 'category_id' => $music->id]);
        Event::factory()->create(['category' => 'Hackathon', 'category_id' => $tech->id]);

        $response = $this->getJson(uri: 'events.show?category_id=' . $tech->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['category' => 'Hackathon']);
        $response->assertJsonMissing(['category' => 'Concert']);
    }

    /** @test */
    public function test_it_filters_events_by_date_range()
    {
        Event::factory()->create([
            'name' => 'Past Event',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(9),
        ]);

        Event::factory()->create([
            'name' => 'Present Event',
            'start_date' => now(),
            'end_date' => now()->addDay(),
        ]);

        Event::factory()->create([
            'name' => 'Future Event',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
        ]);

        $response = $this->getJson('events.index?start_date=' . now()->format('Y-m-d') . '&end_date=' . now()->addDay()->format('Y-m-d'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Past Event']);
        $response->assertJsonMissing(['name' => 'Present Event']);
        $response->assertJsonMissing(['name' => 'Future Event']);
    }
}
