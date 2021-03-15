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

    /** @test */
    public function it_can_show_all_detail_user_when_is_admin()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'type' => "admin"
        ]);

        Sanctum::actingAs($admin);

        $response = $this->get("/api/user/$user->id");

        $response
            ->assertOk()
            ->assertJson([
                "name" => $user->name,
                "email" => $user->email,
                "type" => "pemodal"
            ]);
    }

    /** @test */
    public function it_can_not_show_other_user_detail_when_is_not_admin()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        Sanctum::actingAs($user2);

        $response = $this->get("/api/user/$user->id");

        $response
            ->assertNotFound();
    }

    /** @test */
    public function it_can_show_user_detail()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->get("/api/user/$user->id");

        $response
            ->assertOK()
            ->assertJson([
                'name' => $user->name,
                "email" => $user->email
            ]);
    }

    /** @test */
    public function it_can_update_all_user_info_when_is_admin()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'type' => "admin"
        ]);

        Sanctum::actingAs($admin);

        $req = [
            "name" => "ake",
        ];

        $response = $this->put("/api/user/$user->id", $req);

        $response
            ->assertOk()
            ->assertJson([
                "name" => $req['name'],
                "email" => $user->email,
                "type" => "pemodal"
            ]);
    }

    /** @test */
    public function it_can_not_update_other_user_info_when_is_not_admin()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        Sanctum::actingAs($user2);

        $req = [
            "name" => "ake",
        ];

        $response = $this->put("/api/user/$user->id", $req);

        $response
            ->assertNotFound();
    }

    /** @test */
    public function it_can_update_user_data()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $req = [
            "name" => "ake",
        ];

        $response = $this->put("/api/user/$user->id", $req);

        $response
            ->assertOk()
            ->assertJson([
                "name" => $req['name'],
                "email" => $user->email,
            ]);
    }
}
