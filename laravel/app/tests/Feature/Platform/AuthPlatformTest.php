<?php

namespace Tests\Feature\Platform;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class AuthPlatformTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_orchid_dashboard()
    {
        $user = User::factory()->withDefaultAccess()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->actingAs($user)
            ->get('/admin/dashboard');

        $response->assertStatus(200)
            ->assertSee('Дашборд');
    }

    public function test_admin_can_access_admin_pages()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)
            ->get('/admin/users');

        $response->assertStatus(200)
            ->assertSee('Пользователи');
    }

    public function test_regular_user_cannot_access_admin_pages()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/admin/users');

        $response->assertStatus(403);
    }
}
