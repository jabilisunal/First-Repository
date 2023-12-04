<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\TourFacility
 *
 * @property int $tour_id
 * @property int $facility_id
 * @property-read Facility $facility
 * @property-read Tour|null $tour
 * @method static Builder|TourFacility newModelQuery()
 * @method static Builder|TourFacility newQuery()
 * @method static Builder|TourFacility onlyTrashed()
 * @method static Builder|TourFacility query()
 * @method static Builder|TourFacility whereFacilityId($value)
 * @method static Builder|TourFacility whereTourId($value)
 * @method static Builder|TourFacility withTrashed()
 * @method static Builder|TourFacility withoutTrashed()
 * @mixin Eloquent
 */
class TourFacility extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'tour_facilities';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'facility_id',
        'tour_id',
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
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
