<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int category_id
 * @property string $name
 * @property string $slug
 * @property string $logo_url
 * @property string $image_url
 * @property string $description
 * @property \App\Models\Category $category
 * @property \Illuminate\Database\Eloquent\Collection $sources
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * Don't auto apply mass-assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the brand category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A brand can have many content sources.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }

    /**
     * A brand can have many posts through many sources.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function posts(): HasManyThrough
    {
        return $this->hasManyThrough(Post::class, Source::class);
    }
}
