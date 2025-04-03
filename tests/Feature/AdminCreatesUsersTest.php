<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCreatesUsersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear los roles necesarios
        Role::create(['id' => 1, 'type' => 'admin']);
        Role::create(['id' => 2, 'type' => 'org_admin']);
        Role::create(['id' => 3, 'type' => 'assistant']);

        // Crear organizaciones necesarias
        foreach (range(1, 12) as $id) {
            Organization::factory()->create(['id' => $id]);
        }
    }

    public function test_only_admin_can_create_admin_organization_users()
    {
        // Crear un usuario admin autenticado
        $admin = User::factory()->create([
            'role_id' => 1,
        ]);

        // Hacer solicitud para crear un nuevo usuario org_admin
        $response = $this->actingAs($admin)->postJson(route('users.store'), [
            'username' => 'orgadmin',
            'email' => 'orgadmin@example.com',
            'password' => 'password',
            'name' => 'Organization Admin',
            'role_id' => 2,
            'organization_id' => 1,
        ]);

        // Comprobamos que se haya creado exitosamente
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'orgadmin@example.com',
            'role_id' => 2,
        ]);
    }

    public function test_organization_admin_cannot_create_other_users()
    {

        $org = Organization::factory()->create();

        $orgAdminRole = Role::create(['id' => 2, 'type' => 'org_admin']);
        $targetRole = Role::create(['id' => 2, 'type' => 'org_admin']);
    
        $orgAdmin = User::factory()->create([
            'role_id' => $orgAdminRole->id,
            'organization_id' => $org->id,
        ]);

        $response = $this->actingAs($orgAdmin)->postJson(route('users.store'), [
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'name' => 'Nuevo Usuario',
            'role_id' => $targetRole->id,
            'organization_id' => $org->id,
        ]);

        $response->assertStatus(403);
    }



    public function test_assistant_cannot_create_users()
    {
        $org = Organization::factory()->create();

        $assistantRole = Role::create(['id' => 3, 'type' => 'assistant']);
        $targetRole = Role::create(['id' => 2, 'type' => 'org_admin']);

        $assistant = User::factory()->create([
            'role_id' => $assistantRole->id,
            'organization_id' => $org->id,
        ]);

        $response = $this->actingAs($assistant)->postJson(route('users.store'), [
            'username' => 'anotheruser',
            'email' => 'another@example.com',
            'password' => 'password',
            'name' => 'Asistente Usuario',
            'role_id' => $targetRole->id,
            'organization_id' => $org->id,
        ]);

        $response->assertStatus(403);
    }

}
