<?php

namespace Tests\Feature\Api;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_program()
    {
        $response = $this->get('/api/program');

        $response->assertOk();
    }

    /** @test */
    public function it_can_creates_by_auth_user()
    {
        $user = User::factory()->create();

        $program = [
            "name" => "Program 1",
            "detail" => "coba",
            "location" => "singa",
            "start_at" => "2021-02-20",
            "end_at" => "2021-03-20",
            "target_fund" => 10000
        ];

        Sanctum::actingAs($user);

        $response = $this->post('/api/program', $program);

        $response
            ->assertOk()
            ->assertJson($program);
        
        $this->assertAuthenticated();
    }

    /** @test */
    public function it_should_get_program_individual_item()
    {
        $user = User::factory()->create();

        $this->assertEquals(0, $user->programs()->count());

        $program = Program::factory()->for($user)->create();

        $this->assertEquals(1, $user->programs()->count());

        $response = $this->get('/api/program/'.$program->id);

        $response
            ->assertOk();
    }

    /** @test */
    public function it_should_update_program_on_authenticated_user()
    {
        $user = User::factory()->create();

        $this->assertEquals(0, $user->programs()->count());

        $program = Program::factory()->for($user)->create();

        $this->assertEquals(1, $user->programs()->count());

        $program_update = [
            "name" => "Program 1",
            "detail" => "coba",
            "location" => "singa",
            "start_at" => "2021-02-20",
            "end_at" => "2021-03-20",
            "target_fund" => 10000
        ];

        Sanctum::actingAs($user);

        $response = $this->post('/api/program/'.$program->id, $program_update);
        
        $response
            ->assertOk()
            ->assertJson([
                "message" => true
            ]);
        
        $this->assertEquals(1, $user->programs()->count());
        $this->assertDatabaseHas('programs',[
            "name" => "Program 1"
        ]);
    }

    /** @test */
    public function it_can_delete_program_()
    {
        $user = User::factory()->create();

        $program = Program::factory()->for($user)->create();

        Sanctum::actingAs($user);

        $response = $this->delete('/api/program/'.$program->id);

        $response
            ->assertOk()
            ->assertJson([
                "message" => true
            ]);
    }

    /** @test */
    public function it_can_not_delete_program_does_not_belong_to_user()
    {
        $user = User::factory()->create();

        $program = Program::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->delete('/api/program/'.$program->id);

        $response
            ->assertStatus(404)
            ->assertJson([
                "message" => true
            ]);
    }
}
