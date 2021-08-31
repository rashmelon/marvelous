<?php

namespace Database\Factories;

use App\Models\Example;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExampleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Example::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'userName' => $this->faker->name,
            'lastVisited' => $this->faker->dateTime,
            'lastUpdated' => $this->faker->dateTime,
            'expiryDate' => $this->faker->dateTime,
            'status' => 'status ' . $this->faker->randomNumber(1),
            'city' => $this->faker->city
        ];
    }
}
