<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\OrderStatus
 *
 * @property mixed $id
 * @property mixed $name
 * @method static insert(array[] $ordersStatuses)
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int $order_count
 * @method static Builder|OrderStatus newModelQuery()
 * @method static Builder|OrderStatus newQuery()
 * @method static Builder|OrderStatus onlyTrashed()
 * @method static Builder|OrderStatus query()
 * @method static Builder|OrderStatus whereCreatedAt($value)
 * @method static Builder|OrderStatus whereDeletedAt($value)
 * @method static Builder|OrderStatus whereId($value)
 * @method static Builder|OrderStatus whereName($value)
 * @method static Builder|OrderStatus whereUpdatedAt($value)
 * @method static Builder|OrderStatus withTrashed()
 * @method static Builder|OrderStatus withoutTrashed()
 * @mixin Eloquent
 */
class OrderStatus extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "order_statuses";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "name"
    ];

    protected $appends = [
        'order_count'
    ];

    /**
     * @return int
     */
    public function getOrderCountAttribute(): int
    {
        return Order::where(['status' => $this->id])->count();
    }
}
