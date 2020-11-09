<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testUserCanFetchPosts()
    {
        $this->withoutExceptionHandling();

        $posts = Post::factory()->count(10)->create();

        $this->json('GET', route('api.posts.index'))
            ->assertSuccessful()
            ->assertJson($posts->toArray());
    }

    public function testUserCanFetchPostDetails()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $this->json('GET', route('api.posts.show', $post))
            ->assertSuccessful()
            ->assertJson(Post::first()->toArray());
    }
}
