<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\RentCarFacility
 *
 * @property int $rent_car_id
 * @property int $facility_id
 * @property-read Facility $facility
 * @property-read RentCar|null $rent_car
 * @method static Builder|RentCarFacility newModelQuery()
 * @method static Builder|RentCarFacility newQuery()
 * @method static Builder|RentCarFacility onlyTrashed()
 * @method static Builder|RentCarFacility query()
 * @method static Builder|RentCarFacility whereFacilityId($value)
 * @method static Builder|RentCarFacility whereRentCarId($value)
 * @method static Builder|RentCarFacility withTrashed()
 * @method static Builder|RentCarFacility withoutTrashed()
 * @mixin Eloquent
 */
class RentCarFacility extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'rent_car_facilities';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'facility_id',
        'rent_car_id',
    ];

    /**
     * @return BelongsTo
     */
    public function rent_car(): BelongsTo
    {
        return $this->belongsTo(RentCar::class, 'rent_car_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function facility(): BelongsTo
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
    }
}
