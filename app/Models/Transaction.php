<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property int|null $order_id
 * @property int $customer_id
 * @property int|null $payment_system_id
 * @property int $currency_id
 * @property string $amount
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Transaction newModelQuery()
 * @method static Builder|Transaction newQuery()
 * @method static Builder|Transaction onlyTrashed()
 * @method static Builder|Transaction query()
 * @method static Builder|Transaction whereAmount($value)
 * @method static Builder|Transaction whereCreatedAt($value)
 * @method static Builder|Transaction whereCurrencyId($value)
 * @method static Builder|Transaction whereCustomerId($value)
 * @method static Builder|Transaction whereDeletedAt($value)
 * @method static Builder|Transaction whereId($value)
 * @method static Builder|Transaction whereOrderId($value)
 * @method static Builder|Transaction wherePaymentSystemId($value)
 * @method static Builder|Transaction whereStatus($value)
 * @method static Builder|Transaction whereUpdatedAt($value)
 * @method static Builder|Transaction withTrashed()
 * @method static Builder|Transaction withoutTrashed()
 * @mixin Eloquent
 */
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "transactions";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "customer_id",
        "payment_system_id",
        "currency_id",
        "amount",
        "status"
    ];
}
