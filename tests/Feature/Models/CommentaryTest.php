<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Commentary;
use App\Models\User;
use Carbon\Carbon;
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

    public function testGetsNextCommentaryForACategory()
    {
        $category = Category::factory()->create();

        $firstCommentary = Commentary::factory()->create();
        $firstCommentary->update([
            'category_id' => $category->id,
            'last_assigned' => null,
        ]);

        $secondCommentary = Commentary::factory()->create();
        $secondCommentary->update([
            'category_id' => $category->id,
            'last_assigned' => null,
        ]);

        $next = Commentary::next($category);

        $this->assertTrue($next->is($firstCommentary));

        $firstCommentary->update([
            'last_assigned' => Carbon::now()->subMinutes(10),
        ]);

        $next = Commentary::next($category);

        $this->assertTrue($next->is($secondCommentary));

        $secondCommentary->update([
            'last_assigned' => Carbon::now()->subMinutes(5),
        ]);

        $next = Commentary::next($category);

        $this->assertTrue($next->is($firstCommentary));

        $firstCommentary->update([
            'last_assigned' => Carbon::now()->subMinutes(1),
        ]);

        $next = Commentary::next($category);

        $this->assertTrue($next->is($secondCommentary));
    }
}
