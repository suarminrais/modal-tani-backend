<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{
    Growth,
    Program,
    User
};

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_belongs_to_user(){
        $user = User::factory()->has(Program::factory()->count(3))->create();
        $program = $user->program()->count();

        $this->assertTrue($program === 3);
    }

    /** @test */
    public function it_has_many_growth()
    {
        $user = User::factory()->create();
        $program = Program::factory()->for($user)->has(Growth::factory()->count(5))->create();
        $growth = $program->growth()->count();

        $this->assertTrue($growth === 5);
    }
}
