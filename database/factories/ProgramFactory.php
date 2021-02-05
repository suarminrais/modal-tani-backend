<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Program::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::latest()->get()->id,
            'name' => $this->faker->title,
            'detail' => $this->faker->paragraph(),
            'location' => $this->faker->city,
            'start_at' => $this->faker->date(),
            'end_at' => $this->faker->date(),
            'target_fund' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'status' => "wait"
        ];
    }
}
