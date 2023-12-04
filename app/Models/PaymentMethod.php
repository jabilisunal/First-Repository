<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\PaymentMethod
 *
 * @property mixed $files
 * @method static where(int[] $array)
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $payment_system_id
 * @property int $is_default
 * @property int $status
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read PaymentSystem|null $paymentSystem
 * @method static Builder|PaymentMethod newModelQuery()
 * @method static Builder|PaymentMethod newQuery()
 * @method static Builder|PaymentMethod onlyTrashed()
 * @method static Builder|PaymentMethod query()
 * @method static Builder|PaymentMethod whereCreatedAt($value)
 * @method static Builder|PaymentMethod whereDeletedAt($value)
 * @method static Builder|PaymentMethod whereDescription($value)
 * @method static Builder|PaymentMethod whereId($value)
 * @method static Builder|PaymentMethod whereIsDefault($value)
 * @method static Builder|PaymentMethod whereName($value)
 * @method static Builder|PaymentMethod wherePaymentSystemId($value)
 * @method static Builder|PaymentMethod whereSort($value)
 * @method static Builder|PaymentMethod whereStatus($value)
 * @method static Builder|PaymentMethod whereUpdatedAt($value)
 * @method static Builder|PaymentMethod withTrashed()
 * @method static Builder|PaymentMethod withoutTrashed()
 * @mixin Eloquent
 */
class PaymentMethod extends Model
{
    use HasFactory, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "payment_methods";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "name",
        "payment_system_id",
        "description",
        "is_default",
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
     * @return BelongsTo
     */
    public function paymentSystem(): BelongsTo
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id', 'id');
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
