<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $order_id
 * @property int $customer_id
 * @property int $payment_system_id
 * @property string|null $pan
 * @property string|null $card_type
 * @property string $amount
 * @property int $currency_id
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read PaymentSystem|null $customer
 * @property-read PaymentSystem|null $system
 * @method static Builder|Payment newModelQuery()
 * @method static Builder|Payment newQuery()
 * @method static Builder|Payment onlyTrashed()
 * @method static Builder|Payment query()
 * @method static Builder|Payment whereAmount($value)
 * @method static Builder|Payment whereCardType($value)
 * @method static Builder|Payment whereCreatedAt($value)
 * @method static Builder|Payment whereCurrencyId($value)
 * @method static Builder|Payment whereCustomerId($value)
 * @method static Builder|Payment whereDeletedAt($value)
 * @method static Builder|Payment whereId($value)
 * @method static Builder|Payment whereOrderId($value)
 * @method static Builder|Payment wherePan($value)
 * @method static Builder|Payment wherePaymentSystemId($value)
 * @method static Builder|Payment whereUpdatedAt($value)
 * @method static Builder|Payment withTrashed()
 * @method static Builder|Payment withoutTrashed()
 * @mixin Eloquent
 */
class Payment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = "payments";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'customer_id',
        'payment_system_id',
        'pan',
        'card_type',
        'amount',
        'currency_id'
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(PaymentSystem::class, 'customer_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function system(): BelongsTo
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id', 'id');
    }
}
