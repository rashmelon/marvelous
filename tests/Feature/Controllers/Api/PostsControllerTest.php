<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testAuthenticatedUserCanFetchPosts()
    {
        $this->withoutExceptionHandling();

        Post::factory()->count(10)->create(['published_at' => now()]);
        Passport::actingAs(User::factory()->create());

        $posts = Post::published()->join('brands', 'brands.id', 'posts.brand_id')->get();

        $response  = $this->json('GET', route('api.posts.index'))
            ->assertSuccessful();

        $this->assertEquals($posts->toArray(), $response['data']);
    }

    public function testAuthenticatedUserCanFetchPostsWithPagination()
    {
        $this->withoutExceptionHandling();

        Post::factory()->count(10)->create(['published_at' => now()]);
        Passport::actingAs(User::factory()->create());
        $size= 3;

        $posts = Post::published()->join('brands', 'brands.id', 'posts.brand_id')->limit($size)->get();

        $response  = $this->json('GET', route('api.posts.index').'?page[size]='.$size)
            ->assertSuccessful();

        $this->assertEquals($posts->toArray(), $response['data']);
    }

    public function testUnauthenticatedUserCantFetchPosts()
    {
        Post::factory()->count(10)->create(['published_at' => now()]);

        $this->json('GET', route('api.posts.index'))
            ->assertUnauthorized();
    }

    public function testAuthenticatedUserCanFetchPostDetails()
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();
        Passport::actingAs(User::factory()->create());

        $this->json('GET', route('api.posts.show', $post))
            ->assertSuccessful()
            ->assertJson(Post::first()->toArray());
    }

    public function testUnauthenticatedUserCantFetchPostDetails()
    {
        $post = Post::factory()->create();

        $this->json('GET', route('api.posts.show', $post))
            ->assertUnauthorized();
    }
}
