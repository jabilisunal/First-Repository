<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\PayriffPayment
 *
 * @property int $id
 * @property int $customer_id
 * @property int $payment_system_id
 * @property int $order_id
 * @property int|null $orderId
 * @property string|null $session_id
 * @property string|null $payriff_transaction_id
 * @property string|null $transaction_type
 * @property int|null $purchase_amount
 * @property int|null $currency
 * @property string|null $tran_date_time
 * @property string|null $response_code
 * @property string|null $response_description
 * @property string|null $brand
 * @property string|null $order_status
 * @property string|null $approval_code
 * @property string|null $acq_fee
 * @property string|null $order_description
 * @property string|null $approval_code_scr
 * @property string|null $purchase_amount_scr
 * @property string|null $currency_scr
 * @property string|null $order_status_scr
 * @property string|null $card_registration_response
 * @property string|null $rrn
 * @property string|null $pan
 * @property string|null $card_holder_name
 * @property string|null $card_uid
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read PaymentSystem|null $customer
 * @property-read PaymentSystem|null $system
 * @method static Builder|PayriffPayment newModelQuery()
 * @method static Builder|PayriffPayment newQuery()
 * @method static Builder|PayriffPayment onlyTrashed()
 * @method static Builder|PayriffPayment query()
 * @method static Builder|PayriffPayment whereAcqFee($value)
 * @method static Builder|PayriffPayment whereApprovalCode($value)
 * @method static Builder|PayriffPayment whereApprovalCodeScr($value)
 * @method static Builder|PayriffPayment whereBrand($value)
 * @method static Builder|PayriffPayment whereCardHolderName($value)
 * @method static Builder|PayriffPayment whereCardRegistrationResponse($value)
 * @method static Builder|PayriffPayment whereCardUid($value)
 * @method static Builder|PayriffPayment whereCreatedAt($value)
 * @method static Builder|PayriffPayment whereCurrency($value)
 * @method static Builder|PayriffPayment whereCurrencyScr($value)
 * @method static Builder|PayriffPayment whereCustomerId($value)
 * @method static Builder|PayriffPayment whereDeletedAt($value)
 * @method static Builder|PayriffPayment whereId($value)
 * @method static Builder|PayriffPayment whereOrderDescription($value)
 * @method static Builder|PayriffPayment whereOrderId($value)
 * @method static Builder|PayriffPayment whereOrderStatus($value)
 * @method static Builder|PayriffPayment whereOrderStatusScr($value)
 * @method static Builder|PayriffPayment wherePan($value)
 * @method static Builder|PayriffPayment wherePaymentSystemId($value)
 * @method static Builder|PayriffPayment wherePayriffTransactionId($value)
 * @method static Builder|PayriffPayment wherePurchaseAmount($value)
 * @method static Builder|PayriffPayment wherePurchaseAmountScr($value)
 * @method static Builder|PayriffPayment whereResponseCode($value)
 * @method static Builder|PayriffPayment whereResponseDescription($value)
 * @method static Builder|PayriffPayment whereRrn($value)
 * @method static Builder|PayriffPayment whereSessionId($value)
 * @method static Builder|PayriffPayment whereTranDateTime($value)
 * @method static Builder|PayriffPayment whereTransactionType($value)
 * @method static Builder|PayriffPayment whereUpdatedAt($value)
 * @method static Builder|PayriffPayment withTrashed()
 * @method static Builder|PayriffPayment withoutTrashed()
 * @mixin Eloquent
 */
class PayriffPayment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "payriff_payments";

    /**
     * @var array $guarded
     */
    protected $guarded = [];

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
