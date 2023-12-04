<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\PlaceTag
 *
 * @property int $place_id
 * @property int $tag_id
 * @property-read Place|null $place
 * @property-read Tag|null $tag
 * @method static Builder|PlaceTag newModelQuery()
 * @method static Builder|PlaceTag newQuery()
 * @method static Builder|PlaceTag onlyTrashed()
 * @method static Builder|PlaceTag query()
 * @method static Builder|PlaceTag wherePlaceId($value)
 * @method static Builder|PlaceTag whereTagId($value)
 * @method static Builder|PlaceTag withTrashed()
 * @method static Builder|PlaceTag withoutTrashed()
 * @mixin Eloquent
 */
class PlaceTag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'place_tags';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'tag_id',
        'place_id',
    ];

    /**
     * @return BelongsTo
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
