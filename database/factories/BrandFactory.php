<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'name'        => $this->faker->word,
            'description' => $this->faker->paragraph,
            'logo_url'    => $this->faker->imageUrl(),
            'image_url'   => $this->faker->imageUrl(),
        ];
    }
}
