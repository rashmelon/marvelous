<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string $title
 * @property string $image_url
 * @property string $source_url
 * @property string $description
 * @property int $source_id
 * @property int $commentary_id
 * @property \App\Models\Brand $brand
 * @property \App\Models\Source $source
 * @property \App\Models\Commentary $commentary
 */
class Post extends Model
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
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the post brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the post source.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * A post belongs to a commentary.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commentary(): BelongsTo
    {
        return $this->belongsTo(Commentary::class);
    }
}
