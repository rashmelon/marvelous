<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Source::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand_id' => Brand::factory(),
            'type' => $this->faker->randomElement([
                Source::XML_FEED,
            ]),
            'name' => $this->faker->word,
            'source_url' => $this->faker->url,
            'description' => $this->faker->paragraph,
        ];
    }
}
