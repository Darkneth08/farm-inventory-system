<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_protected_user_endpoint(): void
    {
        $this->getJson('/api/user')
            ->assertUnauthorized();
    }

    public function test_customer_cannot_access_staff_only_routes(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer, 'sanctum')
            ->getJson('/api/branches')
            ->assertForbidden()
            ->assertJsonPath('message', 'Forbidden: insufficient role permissions');
    }

    public function test_staff_can_access_staff_routes(): void
    {
        $staff = User::factory()->staff()->create();

        $this->actingAs($staff, 'sanctum')
            ->getJson('/api/branches')
            ->assertOk()
            ->assertJsonStructure([
                'current_page',
                'data',
                'per_page',
                'total',
            ]);
    }

    public function test_inactive_staff_user_is_blocked_from_staff_routes(): void
    {
        $inactiveStaff = User::factory()->staff()->inactive()->create();

        $this->actingAs($inactiveStaff, 'sanctum')
            ->getJson('/api/branches')
            ->assertForbidden()
            ->assertJsonPath('message', 'Forbidden: user account is inactive');
    }
}
