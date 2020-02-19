<?php

namespace Tests\Feature\Http\Controllers;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    /**
     * Test API Login endpoint.
     *
     * @return void
     */
    public function testLogin()
    {
        assert(User::all()->count(), 0);
        $user = factory(User::class, 'user')->create(
          ['password' => bcrypt($password = 'some_password'),]
        );
        assert(User::all()->count(), 1);

        $response = $this
          ->actingAs($user)
          ->json('POST', '/api/v1/auth/login',
          [
            'email' => $user->email,
            'password' => $password
          ]
        );
        $response
            ->assertStatus(200)
            ->assertSee('success')
            ->assertSee('token');
    }
}
