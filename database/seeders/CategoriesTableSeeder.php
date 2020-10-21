<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->categories()->each(function (array $categoryData) {
            Category::create($categoryData);
        });
    }

    /**
     * Get default categories.
     *
     * @return \Illuminate\Support\Collection
     */
    public function categories(): Collection
    {
        return collect(__('categories'));
    }
}
