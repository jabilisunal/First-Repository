<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\PaymentSystem
 *
 * @property mixed $files
 * @property int $id
 * @property string $name
 * @property string $country_code
 * @property int $status
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @method static Builder|PaymentSystem newModelQuery()
 * @method static Builder|PaymentSystem newQuery()
 * @method static Builder|PaymentSystem onlyTrashed()
 * @method static Builder|PaymentSystem query()
 * @method static Builder|PaymentSystem whereCountryCode($value)
 * @method static Builder|PaymentSystem whereCreatedAt($value)
 * @method static Builder|PaymentSystem whereDeletedAt($value)
 * @method static Builder|PaymentSystem whereId($value)
 * @method static Builder|PaymentSystem whereName($value)
 * @method static Builder|PaymentSystem whereSort($value)
 * @method static Builder|PaymentSystem whereStatus($value)
 * @method static Builder|PaymentSystem whereUpdatedAt($value)
 * @method static Builder|PaymentSystem withTrashed()
 * @method static Builder|PaymentSystem withoutTrashed()
 * @mixin Eloquent
 */
class PaymentSystem extends Model
{
    use HasFactory, HasMedia, SoftDeletes;

    public const PAYRIFF = 1;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "payment_systems";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "name",
        "country_code",
        "status",
        "sort"
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'base_image'
    ];

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
