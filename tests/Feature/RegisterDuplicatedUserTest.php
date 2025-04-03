<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterDuplicatedUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_cant_register_a_duplicated_user()
    {
        User::factory()->create([
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

        $response1 = $this->postJson('/api/v1/register', $userData1);
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

        $response2 = $this->postJson('/api/v1/register', $userData2);
        $response2->assertStatus(422);
        $response2->assertJsonValidationErrors(['username']);
    }
}
