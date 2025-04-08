<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_admin_can_login(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_not_a_user_cant_login(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'user@teste.com',
            'password' => 'password',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['error']);
    }

    public function test_contador_cant_login(): void
    {
        $user = User::factory()->create([
            'role' => 'contador',
            'password' => 'password',
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure(['error']);
    }

    public function test_should_incorrent_email_cant_login(): void
    {
        $response = $this->json('post', '/api/login', [
            'email' => 'testeteste.com',
            'password' => 'password',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)
        ->assertJsonValidationErrorFor('email');

        $response = $this->json('post', '/api/login', [
            'password' => 'password',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)
        ->assertJsonValidationErrorFor('email');
    }

    public function test_should_incorrent_password_cant_login(): void
    {
        $response = $this->json('post', '/api/login', [
            'email' => 'teste@teste.com',
            'password' => '',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)
        ->assertJsonValidationErrorFor('password');

        $response = $this->json('post', '/api/login', [
            'email' => 'teste@teste.com',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422)
        ->assertJsonValidationErrorFor('password');
    }
}
