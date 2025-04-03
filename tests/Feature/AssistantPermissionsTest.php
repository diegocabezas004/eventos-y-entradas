<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssistantPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_assistant_cannot_manage_events()
    {
        $assistant = User::factory()->create([
            'role_id' => 3,
        ]);

        $this->actingAs($assistant);

        $response = $this->postJson(route('events.store'), [
            'name' => 'Event 123',
            'date' => now()->addDays(7),
        ]);

        $response->assertStatus(403);
    }

    public function test_assistant_cannot_manage_users()
    {
        $assistant = User::factory()->create([
            'role_id' => 3,
        ]);

        $this->actingAs($assistant);

        $response = $this->postJson(route('users.store'), [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'role_id' => 2,
        ]);

        $response->assertStatus(403);
    }
}
