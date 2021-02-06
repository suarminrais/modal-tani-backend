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
        User::factory()->hasImage(1)->create(["name" => 'uzumaki']);
        Image::factory()->for(User::factory(),'imageable')->create([
            "name" => "uzumaki.jpg"
        ]);

        $this->assertDatabaseHas('users',[
            "name" => "uzumaki"
        ]);
        $this->assertDatabaseHas("images",[
            "name" => "uzumaki.jpg"
        ]);
    }
}
