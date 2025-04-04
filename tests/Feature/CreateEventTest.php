<?php

namespace Tests\Feature\Events;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CreateEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_event_successfully()
{
    // Crear un usuario con un rol adecuado (por ejemplo, 'admin')
    $adminRole = Role::create(['type' => 'admin']);  // Crear el rol 'admin'
    
    $user = User::factory()->create([
        'role_id' => $adminRole->id,  // Asignar el rol 'admin'
    ]);

    // Autenticar al usuario con Sanctum
    Sanctum::actingAs($user);

    $payload = [
        'organization_id' => '1',
        'name' => 'Titulo',
        'start_date' => '2025-09-28',
        'end_date' => '2025-09-30',
        'location' => 'Sivar',
        'capacity' => '2000',
    ];

    // Enviar la solicitud para crear el evento
    $response = $this->postJson('/api/v1/events', $payload);

    // Asegurarse de que la respuesta tenga el código de estado 201 (creado exitosamente)
    $response->assertStatus(201);
}

}
