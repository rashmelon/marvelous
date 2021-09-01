<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Queries\PostIndexQuery;

class PostsController extends Controller
{
    /**
     * Fetch posts list.
     *
     * @param  \App\Queries\PostIndexQuery  $query
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(PostIndexQuery $query)
    {
        return $query->paginateFromRequest();
    }

    /**
     * Fetch the post details.
     *
     * @param  \App\Models\Post  $post
     * @return \App\Models\Post
     */
    public function show(Post $post)
    {
        return $post;
    }
}
