<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_one_user()
    {
        $user = User::factory()->create(["name" => 'uzumaki']);
        $image = Image::factory()->for(User::factory(),'imageable')->create([
            "name" => "uzumaki.jpg"
        ]);

        $user = $image->user()->count();

        $this->assertTrue($user === 1);
        $this->assertDatabaseHas('users',[
            "name" => "uzumaki"
        ]);
        $this->assertDatabaseHas("images",[
            "name" => "uzumaki.jpg"
        ]);
    }
}