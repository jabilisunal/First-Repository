<?php

namespace App\Models;

use App\Support\Eloquent\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\Address
 *
 * @method static create(array $addressData)
 * @method static where(array $array)
 * @method static updateOrCreate(array $array, array $addressData)
 * @property int $id
 * @property int $model_id
 * @property string|null $model_type
 * @property int $sort
 * @property int $status
 * @property string|null $name
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $zoom
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Address filter(array $filters = [])
 * @method static Builder|Address newModelQuery()
 * @method static Builder|Address newQuery()
 * @method static Builder|Address onlyTrashed()
 * @method static Builder|Address query()
 * @method static Builder|Address whereCreatedAt($value)
 * @method static Builder|Address whereDeletedAt($value)
 * @method static Builder|Address whereId($value)
 * @method static Builder|Address whereLatitude($value)
 * @method static Builder|Address whereLongitude($value)
 * @method static Builder|Address whereModelId($value)
 * @method static Builder|Address whereModelType($value)
 * @method static Builder|Address whereName($value)
 * @method static Builder|Address whereSort($value)
 * @method static Builder|Address whereStatus($value)
 * @method static Builder|Address whereUpdatedAt($value)
 * @method static Builder|Address whereZoom($value)
 * @method static Builder|Address withTrashed()
 * @method static Builder|Address withoutTrashed()
 * @mixin Eloquent
 */
class Address extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'addresses';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'model_id',
        'model_type',
        'sort',
        'status',
        'name',
        'latitude',
        'longitude',
        'zoom',
    ];
}
