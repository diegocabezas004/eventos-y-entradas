<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCreatesUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_create_admin_organization_users()
    {
        $admin = User::factory()->create([
            'role_id' => 1,
        ]);

        $response = $this->actingAs($admin)->postJson(route('users.store'), [
            'name' => 'Organization Admin',
            'email' => 'orgadmin@example.com',
            'password' => 'password',
            'role_id' => 2,
            'organization_id' => 1,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'orgadmin@example.com',
            'role_id' => 2,
        ]);
    }

    public function test_organization_admin_cannot_create_other_users()
    {
        $orgAdmin = User::factory()->create([
            'role_id' => 2,
        ]);

        $response = $this->actingAs($orgAdmin)->postJson(route('users.store'), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'role_id' => 2,
        ]);

        $response->assertStatus(403);
    }

    public function test_assistant_cannot_create_users()
    {
        $assistant = User::factory()->create([
            'role_id' => 3,
        ]);

        $response = $this->actingAs($assistant)->postJson(route('users.store'), [
            'name' => 'Another User',
            'email' => 'another@example.com',
            'password' => 'password',
            'role_id' => 2,
        ]);

        $response->assertStatus(403);
    }
}
