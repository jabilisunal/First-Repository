<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\TourTag
 *
 * @property int $tour_id
 * @property int $tag_id
 * @property-read Tag|null $tag
 * @property-read Tour|null $tour
 * @method static Builder|TourTag newModelQuery()
 * @method static Builder|TourTag newQuery()
 * @method static Builder|TourTag query()
 * @method static Builder|TourTag whereTagId($value)
 * @method static Builder|TourTag whereTourId($value)
 * @mixin Eloquent
 */
class TourTag extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'tour_tags';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'tour_id',
        'tag_id'
    ];

    /**
     * @return BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
