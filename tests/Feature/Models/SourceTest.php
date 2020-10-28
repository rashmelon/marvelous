<?php

namespace Tests\Feature\Models;

use App\Models\Brand;
use App\Models\Source;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SourceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testHasFactory()
    {
        $this->assertInstanceOf(Source::class, Source::factory()->create());
    }

    public function testBelongsToBrand()
    {
        $this->assertInstanceOf(
            Brand::class,
            Source::factory()->create()->brand
        );
    }

    public function testHasManyPosts()
    {
        $this->assertInstanceOf(
            Collection::class,
            Source::factory()->create()->posts
        );
    }
}
