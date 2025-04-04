<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewEventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_all_events()
    {
        // Crear organización para asociar los eventos
        $organization = Organization::factory()->create();

        // Crear un usuario y asociarlo con la organización
        $user = User::factory()->create([
            'organization_id' => $organization->id
        ]);

        // Crear eventos para la organización del usuario
        Event::factory()->create([
            'name' => 'Music Festival',
            'organization_id' => $organization->id
        ]);
        Event::factory()->create([
            'name' => 'Tech Conference',
            'organization_id' => $organization->id
        ]);
        Event::factory()->create([
            'name' => 'Cooking Workshop',
            'organization_id' => $organization->id
        ]);

        // Autenticar al usuario y hacer la solicitud para obtener los eventos
        $response = $this->actingAs($user)->getJson(route('events.index'));

        // Verificar que la respuesta sea exitosa y contenga los eventos esperados
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Music Festival']);
        $response->assertJsonFragment(['name' => 'Tech Conference']);
        $response->assertJsonFragment(['name' => 'Cooking Workshop']);
    }

}
