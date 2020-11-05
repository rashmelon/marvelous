<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string $title
 * @property string $image_url
 * @property string $source_url
 * @property string $description
 * @property int $source_id
 * @property int $commentary_id
 * @property \Illuminate\Support\Carbon $published_at
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
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [
        'published_at',
    ];

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

    /**
     * Get the published bool attribute.
     *
     * @return bool
     */
    public function getPublishedAttribute()
    {
        return $this->isPublished();
    }

    /**
     * Check if a post is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return ! is_null($this->published_at);
    }

    /**
     * Mark the post as published.
     *
     * @param  \Illuminate\Support\Carbon|null  $date
     * @return bool
     */
    public function publish(Carbon $date = null): bool
    {
        return $this->update([
            'published_at' => $date ?? now(),
        ]);
    }

    /**
     * Mark the post as un published.
     *
     * @return bool
     */
    public function unPublish(): bool
    {
        return $this->update([
            'published_at' => null,
        ]);
    }
}
