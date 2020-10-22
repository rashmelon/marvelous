<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Commentary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentaryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testHasFactory()
    {
        $this->assertInstanceOf(Commentary::class, Commentary::factory()->create());
    }

    public function testHasSlug()
    {
        $this->assertNotNull(
            Commentary::factory()->create()->slug
        );
    }

    public function testBelongsToAuthor()
    {
        $this->assertInstanceOf(
            User::class,
            Commentary::factory()->create()->author
        );
    }

    public function testBelongsToCategory()
    {
        $this->assertInstanceOf(
            Category::class,
            Commentary::factory()->create()->category
        );
    }
}
