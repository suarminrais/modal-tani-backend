<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(2)->create();
        \App\Models\Program::factory(6)->create();
        \App\Models\Growth::factory()->create();
        \App\Models\Testimony::factory(6)->has(\App\Models\Image::factory())->create();
    }
}
