<?php

namespace App\Queries;

use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use App\Support\Filters\FuzzyFilter;

class PostIndexQuery extends QueryBuilder
{
    /**
     * PostIndexQuery constructor.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        $query = Post::query()
            ->published()
            ->join('brands', 'brands.id', '=', 'posts.brand_id');

        parent::__construct($query, $request);

        $this->allowedSorts([
            AllowedSort::field('date', 'created_at'),
            AllowedSort::field('brand', 'brand.name'),
        ]);

        $this->allowedFilters([
            AllowedFilter::custom('search', new FuzzyFilter(
                'brands.name',
                'posts.title',
            ))
        ]);
    }
}
