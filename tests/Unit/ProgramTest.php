<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\{
    Growth,
    Image,
    Program,
    User
};

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_belongs_to_user(){
        $user = User::factory()->has(Program::factory()->count(3))->create();
        $program = $user->programs()->count();

        $this->assertTrue($program === 3);
    }

    /** @test */
    public function it_has_many_growthes()
    {
        $user = User::factory()->create();
        $program = Program::factory()->for($user)->has(Growth::factory()->count(5))->create();
        $growth = $program->growth()->count();

        $this->assertTrue($growth === 5);
    }

    /** @test */
    public function it_has_many_image()
    {
        $user = User::factory()->create([
            'name' => 'uzumaki'
        ]);
        $program = Program::factory()
                    ->for($user)
                    ->has(Image::factory()->count(2))
                    ->create();
        $image = $program->images()->count();

        $this->assertTrue($image === 2);
        $this->assertDatabaseHas('users', [
            'name' => 'uzumaki',
        ]);
        $this->assertDatabaseHas('images', [
            'name' => 'default.jpg',
        ]);
    }
}
