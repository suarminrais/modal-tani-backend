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
}
