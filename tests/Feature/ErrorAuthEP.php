<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorAuthEP extends TestCase
{
    use RefreshDatabase;

    public function test_organization_admin_can_only_see_their_own_organization_events()
    {
        $orgA = Organization::factory()->create(['name' => 'Org A']);
        $orgB = Organization::factory()->create(['name' => 'Org B']);

        $adminOrgA = User::factory()->create([
            'role_id' => 2,
            'organization_id' => $orgA->id,
        ]);

        $eventA = Event::factory()->create([
            'name' => 'Evento Org A',
            'organization_id' => $orgA->id,
        ]);

        $eventB = Event::factory()->create([
            'name' => 'Evento Org B',
            'organization_id' => $orgB->id,
        ]);

        $response = $this->actingAs($adminOrgA)->getJson(route('events.index'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Evento Org A']);
        $response->assertJsonMissing(['name' => 'Evento Org B']);
    }
}
