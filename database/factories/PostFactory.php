<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Commentary;
use App\Models\Post;
use App\Models\Source;
use App\States\NotPublished;
use App\States\PostState;
use App\States\Published;
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
            'brand_id' => Brand::factory(),
            'source_id' => Source::factory(),
            'guid' => $this->faker->uuid,
            'title' => $this->faker->sentence,
            'description' => $this->faker->randomHtml(2),
            'image_url' => $this->faker->imageUrl(),
            'source_url' => $this->faker->url,
        ];
    }
    /**
     * Indicate that the user is suspended.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
        public function published()
        {
            return $this->state(function (array $attributes) {
                return [
                    'published_at' => now()
                ];
            });
        }
    }
