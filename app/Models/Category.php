<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property \Illuminate\Database\Eloquent\Collection $brands
 */
class Category extends Model
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
     * Get the category brands.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }

    /**
     * A post has many commentaries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentaries(): HasMany
    {
        return $this->hasMany(Commentary::class);
    }
}
