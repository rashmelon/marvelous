<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    /**
     * Filter to only published posts.
     *
     * @return PostQueryBuilder
     */
    public function published(): PostQueryBuilder
    {
        return $this->whereNotNull('published_at');
    }

    /**
     * Filter to posts with brand id.
     *
     * @param $value
     * @return PostQueryBuilder
     */
    public function brand($value): PostQueryBuilder
    {
        return $this->where('brand_id', $value);
    }

    /**
     * Filter to posts with brand slug.
     *
     * @param $value
     * @return PostQueryBuilder
     */
    public function brandSlug($value): PostQueryBuilder
    {
        return $this->whereHas('brand', function (Builder $builder) use ($value) {
            $builder->where('slug', $value);
        });
    }
}
