<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->brands()->each(function ($data) {
            $data->each(function ($item) {
                Brand::create($item);
            });
        });
    }

    public function brands(): Collection
    {
        return collect(__('brands'))->map(function ($data, $brand) {
            $categoryId = Category::whereSlug($brand)->first()->id;
            return collect($data)->map(function ($data) use ($categoryId) {
                $data['category_id'] = $categoryId;
                return $data;
            });
        })->values();
    }
}
