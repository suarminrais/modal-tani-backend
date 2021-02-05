<?php

namespace Database\Factories;

use App\Models\Growth;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

class GrowthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Growth::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'program_id' => Program::factory(),
            'date' => $this->faker->date(),
            'description' => $this->faker->paragraph
        ];
    }
}
