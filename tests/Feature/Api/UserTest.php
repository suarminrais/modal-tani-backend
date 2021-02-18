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

        $response = $this->get('/api/user/program');

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
        $users = User::factory()->count(9)->create();
        $admin = $users[0]->role->name;
        $role = Role::factory()->create();

        Sanctum::actingAs($users[0]);

        $response = $this->get('/api/admin/user');

        $response
            ->assertOk()
            ->assertJson([
                'data' => true
            ]);

        $this->assertEquals($admin, $role[0]);
    }
}
