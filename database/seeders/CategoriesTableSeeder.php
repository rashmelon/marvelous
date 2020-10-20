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

    public function categories(): Collection
    {
        return collect([
            [
                'name'        => 'Automotive',
                'description' => 'Prestige & Performance are defined. Shop for the latest car promotion and VIP Concierge Services.',
            ],
            [
                'name'        => 'Fashion',
                'description' => 'A Shopping Experience Like No Other! Do you love Prada, Gucci, Valentino, or Michael Kors?',
            ],
            [
                'name'        => 'Home Decor',
                'description' => 'Interior Design 50% Off Daily Offers! Free Home Delivery of your favorite brand is available guaranteed.',
            ],
            [
                'name'        => 'Properties',
                'description' => 'Search for a Million Dollar Home and make your dream come true. Everyday we will reveal a new listing of your choice.',
            ],
        ]);
    }
}
