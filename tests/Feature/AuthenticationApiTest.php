<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_and_receive_a_token(): void
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Kenneth User',
            'email' => 'kenneth@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertCreated()
            ->assertJsonPath('message', 'Registration successful')
            ->assertJsonPath('user.role', 'customer')
            ->assertJsonStructure([
                'message',
                'token',
                'user' => ['id', 'name', 'email', 'role', 'status'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'kenneth@example.com',
            'role' => 'customer',
            'status' => 'active',
        ]);
    }

    public function test_user_can_login_and_fetch_profile_permissions(): void
    {
        $user = User::factory()->staff()->create([
            'email' => 'staff@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $loginResponse = $this->postJson('/api/login', [
            'email' => 'staff@example.com',
            'password' => 'secret123',
        ]);

        $loginResponse->assertOk()
            ->assertJsonPath('message', 'Login successful')
            ->assertJsonPath('user.id', $user->id);

        $token = $loginResponse->json('token');

        $this->assertDatabaseHas('login_activities', [
            'user_id' => $user->id,
            'email' => 'staff@example.com',
            'action' => 'login_success',
        ]);

        $profileResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/user');

        $profileResponse->assertOk()
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('role', 'staff')
            ->assertJsonPath('permissions.manage_inventory', true)
            ->assertJsonPath('permissions.manage_users', false);
    }

    public function test_invalid_login_is_rejected_and_logged(): void
    {
        $user = User::factory()->customer()->create([
            'email' => 'customer@example.com',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'customer@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');

        $this->assertDatabaseHas('login_activities', [
            'user_id' => $user->id,
            'email' => 'customer@example.com',
            'action' => 'login_failed',
        ]);
    }
}
