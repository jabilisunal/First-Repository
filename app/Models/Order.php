<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property mixed $products
 * @property mixed $id
 * @property mixed $status
 * @method static where(int[] $array)
 * @method static create(array $array)
 * @method static findOrFail(int $id)
 * @method static find(int $id)
 * @property int|null $customer_id
 * @property int|null $shipping_method_id
 * @property int|null $payment_method_id
 * @property int|null $payment_system_id
 * @property string $country_code
 * @property string $name
 * @property string $surname
 * @property string $address1
 * @property string|null $address2
 * @property string $city
 * @property string $phone
 * @property string|null $email
 * @property string|null $post_code
 * @property int $is_pay
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Customer|null $customer
 * @property-read PaymentMethod|null $paymentMethod
 * @property-read PaymentSystem|null $paymentSystem
 * @property-read ShippingMethod|null $shippingMethod
 * @property-read OrderStatus|null $statuses
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order onlyTrashed()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress1($value)
 * @method static Builder|Order whereAddress2($value)
 * @method static Builder|Order whereCity($value)
 * @method static Builder|Order whereCountryCode($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereCustomerId($value)
 * @method static Builder|Order whereDeletedAt($value)
 * @method static Builder|Order whereEmail($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereIsPay($value)
 * @method static Builder|Order whereName($value)
 * @method static Builder|Order wherePaymentMethodId($value)
 * @method static Builder|Order wherePaymentSystemId($value)
 * @method static Builder|Order wherePhone($value)
 * @method static Builder|Order wherePostCode($value)
 * @method static Builder|Order whereShippingMethodId($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereSurname($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order withTrashed()
 * @method static Builder|Order withoutTrashed()
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "orders";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'customer_id',
        'shipping_method_id',
        'payment_method_id',
        'payment_system_id',
        'country_code',
        'name',
        'surname',
        'address1',
        'address2',
        'city',
        'phone',
        'email',
        'post_code',
        'status'
    ];

    protected $with = ['statuses'];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }

    /**
     * @return BelongsTo
     */
    public function paymentSystem(): BelongsTo
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function statuses(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'status', 'id');
    }
}
