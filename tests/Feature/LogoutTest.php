<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_logout()
    {

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue(auth()->check());

        $response = $this->postJson('api.logout');
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Sesión cerrada con éxito'
        ]);
    }
}
