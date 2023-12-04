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
 * App\Models\Partner
 *
 * @property mixed $files
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static findOrFail(int $id)
 * @method static get()
 * @property int $id
 * @property int $status
 * @property int $sort
 * @property string|null $url
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @method static Builder|Partner newModelQuery()
 * @method static Builder|Partner newQuery()
 * @method static Builder|Partner onlyTrashed()
 * @method static Builder|Partner query()
 * @method static Builder|Partner whereCreatedAt($value)
 * @method static Builder|Partner whereDeletedAt($value)
 * @method static Builder|Partner whereId($value)
 * @method static Builder|Partner whereSort($value)
 * @method static Builder|Partner whereStatus($value)
 * @method static Builder|Partner whereUpdatedAt($value)
 * @method static Builder|Partner whereUrl($value)
 * @method static Builder|Partner withTrashed()
 * @method static Builder|Partner withoutTrashed()
 * @mixin Eloquent
 */
class Partner extends Model
{
    use HasFactory, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'partners';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'url',
        'status',
        'sort'
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
     * Get the product's base image.
     *
     * @return File
     */
    public function getBaseImageAttribute(): File
    {
        return $this->files->where('pivot.zone', 'base_image')->first() ?: new File;
    }
}
