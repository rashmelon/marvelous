<?php

namespace Database\Factories;

use App\Models\Commentary;
use App\Models\Post;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'source_id' => Source::factory(),
            'commentary_id' => Commentary::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->randomHtml(2),
            'image_url' => $this->faker->imageUrl(),
            'source_url' => $this->faker->url,
        ];
    }
}
