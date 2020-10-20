<?php

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testChecksSuperAdmin()
    {
        $this->seed();

        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole('super-admin');

        $this->assertTrue($user->isSuperAdmin());
    }

    public function testChecksNotSuperAdmin()
    {
        $this->seed();

        $this->assertFalse(
            User::factory()->create()->isSuperAdmin()
        );
    }
}
