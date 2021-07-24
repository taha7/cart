<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class MeTest extends TestCase
{
    public function testItFailsIfNotAuthenticated()
    {
        $this->json('get', 'api/auth/me')->assertStatus(401);
    }

    public function testItReturnsAUserIfAuthorized()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/auth/me')
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
