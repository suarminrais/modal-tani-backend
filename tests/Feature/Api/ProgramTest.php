<?php

namespace Tests\Feature\Api;

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
}
