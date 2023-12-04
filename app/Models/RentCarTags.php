<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\RentCarTags
 *
 * @property int $rent_car_id
 * @property int $tag_id
 * @property-read RentCar|null $place
 * @property-read Tag|null $tag
 * @method static Builder|RentCarTags newModelQuery()
 * @method static Builder|RentCarTags newQuery()
 * @method static Builder|RentCarTags onlyTrashed()
 * @method static Builder|RentCarTags query()
 * @method static Builder|RentCarTags whereRentCarId($value)
 * @method static Builder|RentCarTags whereTagId($value)
 * @method static Builder|RentCarTags withTrashed()
 * @method static Builder|RentCarTags withoutTrashed()
 * @mixin Eloquent
 */
class RentCarTags extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'rent_car_tags';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'tag_id',
        'rent_car_id',
    ];

    /**
     * @return BelongsTo
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(RentCar::class, 'rent_car_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}
