<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    //use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'alicewqse@example.com',
            'password' => '12345',
        ]);

        // Act: Make POST request to login
        $response = $this->postJson('/api/login', [
            'email' => 'alicewqse@example.com',
            'password' => '12345',
        ]);

        // Assert: Check response
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'user',
                     'token',
                 ]);

        $this->assertArrayHasKey('token', $response->json());
    }

    /** @test */
    public function user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'alicewqee@example.com',
            'password' => '12345q',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'alicewe@example.com',
            'password' => '12',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Invalid credentials']);
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'alqm@example.com',
            'password' => '12345',
        ]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Invalid credentials']);
    }

    /** @test */
    public function login_requires_email_and_password()
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422) // Laravel validation error
                 ->assertJsonValidationErrors(['email', 'password']);
    }
}
