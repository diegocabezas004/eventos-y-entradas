<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Role;
use App\Models\Organization;
use App\Models\EventCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErrorAuthEP extends TestCase
{
    use RefreshDatabase;

    public function test_organization_admin_can_only_see_their_own_organization_events()
    {
        // Crear el rol de admin de organización (id fijo para control)
        $orgAdminRole = Role::create([
            'id' => 2,
            'type' => 'org_admin',
        ]);

        // Crear categoría para los eventos
        $category = EventCategory::create(['category' => 'Tecnología']);

        // Crear dos organizaciones
        $org1 = Organization::factory()->create(['name' => 'Org Uno']);
        $org2 = Organization::factory()->create(['name' => 'Org Dos']);

        // Crear un admin de la primera organización
        $adminUser = User::factory()->create([
            'role_id' => $orgAdminRole->id,
            'organization_id' => $org1->id,
        ]);

        // Crear eventos para ambas organizaciones
        $event1 = Event::factory()->create([
            'name' => 'Evento Org Uno',
            'organization_id' => $org1->id,
            'category_id' => $category->id,
        ]);

        $event2 = Event::factory()->create([
            'name' => 'Evento Org Dos',
            'organization_id' => $org2->id,
            'category_id' => $category->id,
        ]);

        // Hacer la petición como admin de Org Uno
        $response = $this->actingAs($adminUser)->getJson(route('events.index'));

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Evento Org Uno']);
        $response->assertJsonMissing(['name' => 'Evento Org Dos']);
    }
}
