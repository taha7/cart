<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testItRequiresData()
    {
        $requires = ['email', 'password'];

        $this->json('POST', 'api/auth/login', [])
            ->assertJsonValidationErrors($requires);
    }

    public function testItAcceptsTheRightEmailAndPassword()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/login', [
            'email' => $user->email,
            'password' => 'nope'
        ])->assertJsonValidationErrors(['email']);
    }

    public function testItReturnsToken()
    {
        $user = factory(User::class)->raw();

        factory(User::class)->create($user);

        $this->json('POST', 'api/auth/login', [
            'email' => $user['email'],
            'password' => $user['password']
        ])
            ->assertJsonStructure([
                'meta' => ['token']
            ]);
    }
}
