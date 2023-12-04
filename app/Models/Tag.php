<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Tag newModelQuery()
 * @method static Builder|Tag newQuery()
 * @method static Builder|Tag onlyTrashed()
 * @method static Builder|Tag query()
 * @method static Builder|Tag whereCreatedAt($value)
 * @method static Builder|Tag whereDeletedAt($value)
 * @method static Builder|Tag whereId($value)
 * @method static Builder|Tag whereName($value)
 * @method static Builder|Tag whereSlug($value)
 * @method static Builder|Tag whereUpdatedAt($value)
 * @method static Builder|Tag withTrashed()
 * @method static Builder|Tag withoutTrashed()
 * @mixin Eloquent
 */
class Tag extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "tags";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        "id",
        "name",
        "slug"
    ];
}
