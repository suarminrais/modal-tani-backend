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
            ->assertJsonCount(10, 'data');
    }
}
