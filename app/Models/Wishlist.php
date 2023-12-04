<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Wishlist
 *
 * @property int $id
 * @property int $customer_id
 * @property int $product_id
 * @property-read Customer|null $customer
 * @method static Builder|Wishlist newModelQuery()
 * @method static Builder|Wishlist newQuery()
 * @method static Builder|Wishlist query()
 * @method static Builder|Wishlist whereCustomerId($value)
 * @method static Builder|Wishlist whereId($value)
 * @method static Builder|Wishlist whereProductId($value)
 * @mixin Eloquent
 */
class Wishlist extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "wishlists";

    /**
     * @var string[]
     */
    protected $fillable = [
        "id",
        "customer_id",
        "product_id"
    ];

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
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
