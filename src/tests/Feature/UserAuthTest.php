<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthTest extends TestCase
{
    //use RefreshDatabase;

    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
        'name' => 'Alice',
        'email' => 'alice@example.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure(['user', 'token']);

    }
    
}
