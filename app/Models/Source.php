<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $brand_id
 * @property string $type
 * @property string $source_url
 * @property string $description
 * @property \App\Models\Brand $brand
 */
class Source extends Model
{
    use HasFactory;

    public const XML_FEED = 'xml_feed';

    /**
     * A source belongs to a brand.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
