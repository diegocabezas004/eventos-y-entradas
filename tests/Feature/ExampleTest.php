<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Ticket_Type;
use App\Models\Role;
use App\Models\Organization;
use App\Models\Event;
use App\Models\Event_Session;
use App\Models\Event_Category;
use App\Models\Attendee;
use App\Models\Attendance;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_an_event_succesfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payload = [
            'organization_id' => '1',
            'name' => 'Titulo',
            'start_date' => '28/09/2025',
            'end_date' => '30/09/2025',
            'location' => 'Sivar',
            'capacity' => '2000',
        ];

        $response = $this->postJson('/api/v1/events', $payload);

        $response->assertStatus(201);
    }

    public function test_cant_create_a_post_with_wrong_dates()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $eventData = [
            'organization_id' => '1',
            'name' => 'Titulo',
            'start_date' => '30/09/2025',
            'end_date' => '28/09/2025',
            'location' => 'Sivar',
            'capacity' => '2000',
        ];

        $response = $this->postJson('api/v1/events', $eventData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_date']);
    }

    public function test_error_al_crear_un_evento_con_campos_incompletos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $eventData = [
            'organization_id' => '1',
            'name' => 'Cash_inc',
            'start_date' => '28/09/2025',
            'end_date' => '30/09/2025',
            'location' => 'Sivar',
        ];

        $response = $this->postJson('api/v1/events', $eventData);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['capacity']);
    }

    public function test_user_cant_buy_tickets_without_being_logged_in()
    {
        $ticketData = [
            'ticket_type_id' => 1,
            'attendee_id' => 5,
            'ticket_unique_code' => 'EVENTO2025-' . Str::random(8),
        ];

        $response = $this->postJson('api/v1/tickets', $ticketData);
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function test_succesful_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue(auth()->check());

        $response = $this->postJson('api/v1/logout');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Sesión cerrada con éxito'
        ]);
    }

    public function test_cant_register_a_duplicated_user()
    {
        $existingUser = User::factory()->create([
            'email' => 'usuario@ejemplo.com',
            'username' => 'usuario123456'
        ]);

        $userData1 = [
            'name' => 'Nuevo usuario',
            'email' => 'usuario@ejemplo.com', 
            'username' => 'usuario_nuevo',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'full_name' => 'Nuevo Usuario Completo',
            'role_id' => 2,
            'organization_id' => 1,
        ];

        $response1 = $this->postJson('api/v1/register', $userData1);
        $response1->assertStatus(422);
        $response1->assertJsonValidationErrors(['email']);

        $userData2 = [
            'name' => 'Otro usuario',
            'email' => 'ejemplo@example.com',
            'username' => 'usuario123456', 
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'full_name' => 'Nuevo Usuario Completo',
            'role_id' => 2,
            'organization_id' => 1,
        ];

        $response2 = $this->postJson('api/v1/register', $userData2);
        $response2->assertStatus(422);
        $response2->assertJsonValidationErrors(['username']);
    }
}