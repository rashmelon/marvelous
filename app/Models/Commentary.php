<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property \App\Models\User $author
 */
class Commentary extends Model
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
        'last_assigned',
    ];

    /**
     * Get the next commentary to be assigned for the category.
     *
     * @param  \App\Models\Category  $category
     * @return \App\Models\Commentary
     */
    public static function next(Category $category): Commentary
    {
        $notYetAssigned = static::where('category_id', $category->id)->whereNull('last_assigned')->first();

        if (! is_null($notYetAssigned)) {
            return $notYetAssigned;
        }

        return static::where('category_id', $category->id)->orderBy('last_assigned', 'asc')->first();
    }

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
     * Get the commentary author.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the commentary category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
