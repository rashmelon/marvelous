<?php

namespace Tests\Feature\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Commentary;
use App\Models\Post;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testHasFactory()
    {
        $this->assertInstanceOf(Post::class, Post::factory()->create());
    }

    public function testHasSlug()
    {
        $this->assertNotNull(
            Post::factory()->create()->slug
        );
    }

    public function testBelongsToSource()
    {
        $this->assertInstanceOf(
            Source::class,
            Post::factory()->create()->source,
        );
    }

    public function testBelongsToBrand()
    {
        $this->assertInstanceOf(
            Brand::class,
            Post::factory()->create()->brand,
        );
    }

    /** @test */
    public function testAssignsCommentWhenCreated()
    {
        $category = Category::factory()->create();

        Commentary::factory()->count(10)->create([
            'category_id' => $category->id,
        ]);

        $brand = Brand::factory()->create([
            'category_id' => $category->id,
        ]);

        /** @var Post $post */
        $post = Post::factory()->create([
            'brand_id' => $brand->id,
        ]);

        $this->assertNotNull($post->commentary_id);
    }
}
