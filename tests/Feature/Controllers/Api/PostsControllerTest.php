<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\Brand;
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

        Post::factory()->published()->count(10)->create();
        Passport::actingAs(User::factory()->create());

        $posts = Post::published()->join('brands', 'brands.id', 'posts.brand_id')->get();

        $this->json('GET', route('api.posts.index'))
            ->assertSuccessful()
            ->assertJson(['data' => $posts->toArray()]);
    }

    public function testAuthenticatedUserCanFetchPostsFilteredByBrandId()
    {
        $this->withoutExceptionHandling();

        $brand = Brand::factory()->create();
        Post::factory()->brand($brand)->published()->count(10)->create();
        Post::factory()->published()->count(10)->create();
        Passport::actingAs(User::factory()->create());

        $posts = Post::published()->join('brands', 'brands.id', 'posts.brand_id')->brand($brand->id)->get();

        $this->json('GET', route('api.posts.index'))
            ->assertSuccessful()
            ->assertJson(['data' => $posts->toArray()]);
    }

    public function testAuthenticatedUserCanFetchPostsFilteredByBrandSlug()
    {
        $this->withoutExceptionHandling();

        $brand = Brand::factory()->create();
        Post::factory()->brand($brand)->published()->count(10)->create();
        Post::factory()->published()->count(10)->create();
        Passport::actingAs(User::factory()->create());

        $posts = Post::published()->join('brands', 'brands.id', 'posts.brand_id')->brandSlug($brand->slug)->get();

        $this->json('GET', route('api.posts.index'))
            ->assertSuccessful()
            ->assertJson(['data' => $posts->toArray()]);
    }

    public function testAuthenticatedUserCanFetchPostsWithPagination()
    {
        $this->withoutExceptionHandling();

        Post::factory()->published()->count(10)->create();
        Passport::actingAs(User::factory()->create());
        $size= 3;

        $posts = Post::published()->join('brands', 'brands.id', 'posts.brand_id')->limit($size)->get();

        $response  = $this->json('GET', route('api.posts.index').'?page[size]='.$size)
            ->assertSuccessful()
            ->assertJson(['data' => $posts->toArray()]);

        $this->assertArrayHasKey('current_page', $response);
        $this->assertArrayHasKey('first_page_url', $response);
        $this->assertArrayHasKey('last_page', $response);
        $this->assertArrayHasKey('last_page_url', $response);
        $this->assertArrayHasKey('next_page_url', $response);
        $this->assertArrayHasKey('per_page', $response);
        $this->assertArrayHasKey('total', $response);
        $this->assertArrayHasKey('links', $response);
    }

    public function testUnauthenticatedUserCanNotFetchPosts()
    {
        Post::factory()->published()->count(10)->create();

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

    public function testUnauthenticatedUserCanNotFetchPostDetails()
    {
        $post = Post::factory()->create();

        $this->json('GET', route('api.posts.show', $post))
            ->assertUnauthorized();
    }
}
