<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_register_and_login()
    {
        $registerResponse = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        $registerResponse->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        
        $loginResponse = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);
        
        $loginResponse->assertOk();
        $this->assertNotNull($loginResponse->json('token'));
    }
    
    public function test_user_cannot_login_with_wrong_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);
        
        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);
        
        $response->assertStatus(422);
    }
    
    public function test_user_can_logout()
    {
        $user = User::factory()->create(['password' => Hash::make('password123')]);
        
        $token = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->json('token');
        
        $response = $this->withToken($token)->postJson('/api/v1/logout');
        $response->assertOk();
    }
    
    public function test_protected_route_requires_auth()
    {
        $response = $this->getJson('/api/v1/me');
        $response->assertStatus(401);
        
        $user = User::factory()->create(['password' => Hash::make('password123')]);
        $token = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->json('token');
        
        $response = $this->withToken($token)->getJson('/api/v1/me');
        $response->assertOk();
    }
}