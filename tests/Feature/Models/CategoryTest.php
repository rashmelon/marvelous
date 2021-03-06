<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testHasFactory()
    {
        $this->assertInstanceOf(Category::class, Category::factory()->create());
    }

    public function testHasSlug()
    {
        $this->assertNotNull(
            Category::factory()->create()->slug
        );
    }

    public function testHasManyBrands()
    {
        $this->assertInstanceOf(
            Collection::class,
            Category::factory()->create()->brands
        );
    }

    public function testHasManyCommentaries()
    {
        $this->assertInstanceOf(
            Collection::class,
            Category::factory()->create()->commentaries
        );
    }
}
