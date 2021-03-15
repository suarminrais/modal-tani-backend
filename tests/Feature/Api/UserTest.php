<?php

namespace Tests\Feature\Api;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_program_associate_in_user()
    {
        $user = User::factory()->create();

        $program = Program::factory()->for($user)->count(9)->create();

        Sanctum::actingAs($user);

        $response = $this->get('/api/user');

        $response
            ->assertOk()
            ->assertJson([
                'data' => true
            ]);

        $this->assertEquals($program->count(), $user->programs()->count());
    }

    /** @test */
    public function it_can_see_all_user_when_is_admin()
    {
        User::factory()->count(9)->create();
        $admin = User::factory()->create([
            "type" => "admin"
        ]);

        Sanctum::actingAs($admin);

        $response = $this->get('/api/user');

        $response
            ->assertOk()
            ->assertJsonCount(10);
    }

    /** @test */
    public function it_can_create_user_when_is_admin()
    {
        $admin = User::factory()->create([
            "type" => "admin"
        ]);

        Sanctum::actingAs($admin);

        $user = [
            "name" => "amien",
            "email" => "test@test.com",
            "password" => "asdfgh",
            "password_confirmation" => "asdfgh",
        ];

        $response = $this->post('/api/user', $user);

        $response
            ->assertStatus(201)
            ->assertJson([
                "name" => $user['name'],
                "email" => $user['email']
            ]);
    }

    /** @test */
    public function it_can_not_create_user_when_is_not_admin()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $user = [
            "name" => "amien",
            "email" => "test@test.com",
            "password" => "asdfgh",
            "password_confirmed" => "asdfgh",
        ];

        $response = $this->post('/api/user', $user);

        $response
            ->assertNotFound();
    }
}
