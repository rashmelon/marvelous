<?php

namespace Tests\Feature\Models;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testHasFactory()
    {
        $this->assertInstanceOf(Brand::class, Brand::factory()->create());
    }

    public function testHasSlug()
    {
        $this->assertNotNull(
            Brand::factory()->create()->slug
        );
    }

    public function testBelongsToCategory()
    {
        $this->assertInstanceOf(
            Category::class,
            Brand::factory()->create()->category
        );
    }

    public function testHasManySources()
    {
        $this->assertInstanceOf(
            Collection::class,
            Brand::factory()->create()->sources
        );
    }

    public function testHasManyPosts()
    {
        $this->assertInstanceOf(
            Collection::class,
            Brand::factory()->create()->posts
        );
    }
}
