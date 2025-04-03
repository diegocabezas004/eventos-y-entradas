<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use App\Models\EventCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssistantPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_assistant_cannot_manage_events()
    {
        // Creamos los datos necesarios para el test
        $assistantRole = Role::factory()->create(['id' => 3]);
        $organization = Organization::factory()->create();
        $category = EventCategory::factory()->create(['category' => 'Música']);

        $assistant = User::factory()->create([
            'role_id' => $assistantRole->id,
            'organization_id' => $organization->id,
        ]);

        $this->actingAs($assistant);

        $response = $this->postJson(route('events.store'), [
            'name' => 'Event 123',
            'start_date' => now()->addDays(7)->toDateTimeString(),
            'end_date' => now()->addDays(8)->toDateTimeString(),
            'location' => 'Auditorio ESEN',
            'capacity' => 100,
            'organization_id' => $organization->id,
            'category_id' => $category->id,
        ]);

        $response->assertStatus(403);
    }

    public function test_assistant_cannot_manage_users()
    {
        // Creamos los datos necesarios
        $assistantRole = Role::factory()->create(['id' => 3]);
        $org = Organization::factory()->create();
        $targetRole = Role::factory()->create(['id' => 2]);

        $assistant = User::factory()->create([
            'role_id' => $assistantRole->id,
            'organization_id' => $org->id,
        ]);

        $this->actingAs($assistant);

        $response = $this->postJson(route('users.store'), [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'full_name' => 'Test User',
            'role_id' => $targetRole->id,
            'organization_id' => $org->id,
        ]);

        $response->assertStatus(403);
    }
}
