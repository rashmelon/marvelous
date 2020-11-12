<?php

namespace App\Models;

use App\Builders\PostQueryBuilder;
use App\Observers\PostObserver;
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
 * @property Carbon $published_at
 * @property Brand $brand
 * @property Source $source
 * @property Commentary $commentary
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
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::observe(PostObserver::class);
    }

    /**
     * overrides default builder.
     *
     * @param $query
     * @return PostQueryBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new PostQueryBuilder($query);
    }

    /**
     * Get the options for generating the slug.
     *
     * @return SlugOptions
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
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the post source.
     *
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * A post belongs to a commentary.
     *
     * @return BelongsTo
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
     * @param Carbon|null  $date
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
