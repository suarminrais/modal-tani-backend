<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_login()
    {
        $user = User::factory()->create();

        $this->post('api/login',[
            "email" => $user->email,
            "password" => 'password'
        ]);

        $this->assertAuthenticated();
    }

    /** @test */
    public function it_can_not_login_with_wrong_password()
    {
        $user = User::factory()->create();

        $this->post('/api/login',[
            "email" => $user->email,
            "password" => 'passwrong'
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function it_can_logout()
    {
        Sanctum::actingAs(User::factory()->create());

        $this->post('/api/logout');
        
        $this->assertAuthenticated();
    }

    /** @test */
    public function it_can_not_logout()
    {
        $this->post('/api/logout');
        
        $this->assertGuest();
    }
}
