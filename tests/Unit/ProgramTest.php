<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{
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
    
}
