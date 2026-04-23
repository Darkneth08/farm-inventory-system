<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_user_has_role_matches_assigned_role(): void
    {
        $user = new User(['role' => 'staff']);

        $this->assertTrue($user->hasRole('staff'));
        $this->assertTrue($user->hasRole('customer', 'staff'));
        $this->assertFalse($user->hasRole('admin', 'manager'));
    }

    public function test_super_admin_has_access_to_any_role_check(): void
    {
        $user = new User(['role' => 'super_admin']);

        $this->assertTrue($user->hasRole('customer'));
        $this->assertTrue($user->hasRole('staff', 'admin'));
    }
}
