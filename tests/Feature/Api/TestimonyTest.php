<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TestimonyTest extends TestCase
{

    use RefreshDatabase;
    /** @test */
    public function it_can_make_testimony_when_is_admin()
    {
        $admin = User::factory()->create([
            'type' => 'admin'
        ]);

        Sanctum::actingAs($admin);

        Storage::fake();

        $file = UploadedFile::fake()->image("contoh.png");

        $req = [
            "name" => "Uzumaki",
            "job" => "programmer",
            "detail" => "lorem ipsum dolor sit amet",
            "image" => $file
        ];

        $response = $this->post('/api/testimony', $req);

        $response
            ->assertOk()
            ->assertJson([
                "message" => "success"
            ]);

        Storage::assertExists('images');
    }
}
