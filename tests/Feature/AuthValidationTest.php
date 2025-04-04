<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_fails_if_required_fields_are_missing()
    {
        $response = $this->postJson(route('api.register'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'username',
            'email',
            'password',
            'full_name',
            'role_id',
            'organization_id',
        ]);
    }

    public function test_login_fails_if_required_fields_are_missing()
    {
        $response = $this->postJson(route('api.login'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }
}
