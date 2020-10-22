<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Commentary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentaryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commentary::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'title'       => $this->faker->title,
            'body'        => $this->faker->paragraph,
        ];
    }
}
