<?php

namespace Tests\Feature\Models\Auth;

use App\Models\User;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_an_email()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', ['email' => 'nope'])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {
        $user = factory(User::class)->create();
        $this->json('POST', 'api/auth/register', ['email' => $user->email])
            ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    public function test_it_registers_a_user()
    {
        $this->json('POST', 'api/auth/register', $userRaw = factory(User::class)->raw())
            ->assertJsonFragment([
                'name' => $userRaw['name'],
                'email' => $userRaw['email']
            ]);
    }

    public function test_it_adds_a_user_on_database()
    {
        $this->json('POST', 'api/auth/register', $userRaw = factory(User::class)->raw());

        $this->assertDatabaseHas('users', [
            'name' => $userRaw['name'],
            'email' => $userRaw['email']
        ]);
    }
}
