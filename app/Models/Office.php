<?php

namespace App\Models;

use App\Support\Eloquent\Filterable;
use App\Support\Eloquent\HasMedia;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Office
 *
 * @property mixed $files
 * @method static insert(array[] $offices)
 * @method static truncate()
 * @property int $id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $lat
 * @property string|null $lng
 * @property int $sort
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @method static Builder|Office filter(array $filters = [])
 * @method static Builder|Office newModelQuery()
 * @method static Builder|Office newQuery()
 * @method static Builder|Office onlyTrashed()
 * @method static Builder|Office query()
 * @method static Builder|Office whereAddress($value)
 * @method static Builder|Office whereCreatedAt($value)
 * @method static Builder|Office whereDeletedAt($value)
 * @method static Builder|Office whereId($value)
 * @method static Builder|Office whereLat($value)
 * @method static Builder|Office whereLng($value)
 * @method static Builder|Office whereName($value)
 * @method static Builder|Office whereSort($value)
 * @method static Builder|Office whereStatus($value)
 * @method static Builder|Office whereUpdatedAt($value)
 * @method static Builder|Office withTrashed()
 * @method static Builder|Office withoutTrashed()
 * @mixin Eloquent
 */
class Office extends Model
{
    use HasFactory, HasMedia, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "offices";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "name",
        "address",
        "lat",
        "lng",
        "status",
        "sort"
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
     * @return HasMany
     */
    public function shelves(): HasMany
    {
        return $this->hasMany(Shelf::class, 'office_id', 'id');
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
