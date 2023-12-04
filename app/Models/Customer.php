<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\PersonalAccessToken;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Customer
 *
 * @property mixed $files
 * @property mixed $wishlist
 * @property mixed $id
 * @property mixed $name
 * @property mixed $surname
 * @property mixed $country_code
 * @property mixed $phone
 * @property mixed $email
 * @property string $type
 * @property string|null $company_name
 * @property string|null $tax_id
 * @property string|null $password
 * @property string $locale
 * @property string $timezone
 * @property string|null $remember_token
 * @property Carbon|null $email_verified_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read CustomerAddress|null $address
 * @property-read Collection<int, CustomerAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Order> $orders
 * @property-read int|null $orders_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer onlyTrashed()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereCompanyName($value)
 * @method static Builder|Customer whereCountryCode($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereDeletedAt($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereEmailVerifiedAt($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereLocale($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer wherePassword($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer whereRememberToken($value)
 * @method static Builder|Customer whereSurname($value)
 * @method static Builder|Customer whereTaxId($value)
 * @method static Builder|Customer whereTimezone($value)
 * @method static Builder|Customer whereType($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @method static Builder|Customer withTrashed()
 * @method static Builder|Customer withoutTrashed()
 * @mixin Eloquent
 */
class Customer extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "customers";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'type',
        'name',
        'surname',
        'email',
        'phone',
        'password',
        'locale',
        'timezone',
        'country_code'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array $appends
     */
    protected $appends = [
        'base_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'id')
            ->where('is_default', 1);
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'id');
    }


    /**
     * @return BelongsToMany
     */
    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            Wishlist::class,
            'customer_id',
            'product_id'
        )->with(['variant' => function ($query) {
            $query->where(['is_default' => 1]);
        }]);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    /**
     * Get the product's base image.
     *
     * @return File
     */
    public function getBaseImageAttribute(): File
    {
        return $this->files->where('pivot.zone', 'base_image')->first() ?: new File;
    }
}
