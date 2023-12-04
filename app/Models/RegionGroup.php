<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static where(int[] $array)
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @property mixed $files
 */
class RegionGroup extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory,
        Translatable,
        HasMedia,
        Filterable,
        SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'region_groups';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'sort',
        'slug',
        'status'
    ];

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'region_group_id';

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'name',
        'description'
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
     * @return BelongsToMany
     */
    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(
            Destination::class,
            RegionGroupDestination::class,
            'region_group_id',
            'destination_id'
        );
    }

    /**
     * @return string[][]
     */
    public function getFilters(): array
    {
        return [
            'includes' => [],
            'filters' => ['name'],
            'sorts' => ['created_at']
        ];
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
