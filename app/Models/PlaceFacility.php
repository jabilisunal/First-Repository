<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PlaceFacility
 *
 * @property int $place_id
 * @property int $facility_id
 * @property-read Facility $facility
 * @property-read Place|null $place
 * @method static Builder|PlaceFacility newModelQuery()
 * @method static Builder|PlaceFacility newQuery()
 * @method static Builder|PlaceFacility onlyTrashed()
 * @method static Builder|PlaceFacility query()
 * @method static Builder|PlaceFacility whereFacilityId($value)
 * @method static Builder|PlaceFacility wherePlaceId($value)
 * @method static Builder|PlaceFacility withTrashed()
 * @method static Builder|PlaceFacility withoutTrashed()
 * @mixin Eloquent
 */
class PlaceFacility extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'place_facilities';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'facility_id',
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
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
