<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function testItRequiresData()
    {
        $requires = ['name', 'email', 'password'];

        $this->json('post', 'api/auth/register', [])
            ->assertJsonValidationErrors($requires);
    }

    public function testItRequiresAUniqueEmail()
    {
        $user = factory(User::class)->create();

        $this->json('post', 'api/auth/register', [
            'email' => $user->email
        ])->assertJsonValidationErrors([
            'email'
        ]);
    }

    public function testItRegistersAUser()
    {
        $userData = factory(User::class)->raw();

        $this->json('post', 'api/auth/register', $userData)
            ->assertJsonFragment([
                'name' => $userData['name'],
                'email' => $userData['email']
            ]);
    }
}
