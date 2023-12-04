<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\ShippingMethod
 *
 * @method static where(int[] $array)
 * @method static truncate()
 * @method static insert(array[] $shippingMethods)
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $is_default
 * @property int $status
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|ShippingMethod newModelQuery()
 * @method static Builder|ShippingMethod newQuery()
 * @method static Builder|ShippingMethod onlyTrashed()
 * @method static Builder|ShippingMethod query()
 * @method static Builder|ShippingMethod whereCreatedAt($value)
 * @method static Builder|ShippingMethod whereDeletedAt($value)
 * @method static Builder|ShippingMethod whereId($value)
 * @method static Builder|ShippingMethod whereIsDefault($value)
 * @method static Builder|ShippingMethod whereName($value)
 * @method static Builder|ShippingMethod wherePrice($value)
 * @method static Builder|ShippingMethod whereSort($value)
 * @method static Builder|ShippingMethod whereStatus($value)
 * @method static Builder|ShippingMethod whereUpdatedAt($value)
 * @method static Builder|ShippingMethod withTrashed()
 * @method static Builder|ShippingMethod withoutTrashed()
 * @mixin Eloquent
 */
class ShippingMethod extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "shipping_methods";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "name",
        "price",
        "is_default",
        "status",
        "sort",
    ];
}
