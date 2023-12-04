<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\CustomerAddress
 *
 * @property int $id
 * @property int|null $customer_id
 * @property string $address_title
 * @property string $country_code
 * @property string $name
 * @property string $surname
 * @property string $address1
 * @property string|null $address2
 * @property string $city
 * @property string $phone
 * @property string $email
 * @property string $post_code
 * @property string $address
 * @property string $lat
 * @property string $lng
 * @property string $zoom
 * @property int $is_default
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Customer|null $customer
 * @method static Builder|CustomerAddress newModelQuery()
 * @method static Builder|CustomerAddress newQuery()
 * @method static Builder|CustomerAddress onlyTrashed()
 * @method static Builder|CustomerAddress query()
 * @method static Builder|CustomerAddress whereAddress($value)
 * @method static Builder|CustomerAddress whereAddress1($value)
 * @method static Builder|CustomerAddress whereAddress2($value)
 * @method static Builder|CustomerAddress whereAddressTitle($value)
 * @method static Builder|CustomerAddress whereCity($value)
 * @method static Builder|CustomerAddress whereCountryCode($value)
 * @method static Builder|CustomerAddress whereCreatedAt($value)
 * @method static Builder|CustomerAddress whereCustomerId($value)
 * @method static Builder|CustomerAddress whereDeletedAt($value)
 * @method static Builder|CustomerAddress whereEmail($value)
 * @method static Builder|CustomerAddress whereId($value)
 * @method static Builder|CustomerAddress whereIsDefault($value)
 * @method static Builder|CustomerAddress whereLat($value)
 * @method static Builder|CustomerAddress whereLng($value)
 * @method static Builder|CustomerAddress whereName($value)
 * @method static Builder|CustomerAddress wherePhone($value)
 * @method static Builder|CustomerAddress wherePostCode($value)
 * @method static Builder|CustomerAddress whereSurname($value)
 * @method static Builder|CustomerAddress whereUpdatedAt($value)
 * @method static Builder|CustomerAddress whereZoom($value)
 * @method static Builder|CustomerAddress withTrashed()
 * @method static Builder|CustomerAddress withoutTrashed()
 * @mixin Eloquent
 */
class CustomerAddress extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "customer_addresses";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "customer_id",
        "address_title",
        "country_code",
        "name",
        "surname",
        "address1",
        "address2",
        "city",
        "phone",
        "email",
        "post_code",
        "is_default"
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "customer_id", "id");
    }
}
