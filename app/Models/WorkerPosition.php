<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use TypiCMS\NestableCollection;
use TypiCMS\NestableTrait;

/**
 * App\Models\WorkerPosition
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $position_name
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read NestableCollection<int, WorkerPosition> $child
 * @property-read int|null $child_count
 * @property-read WorkerPosition|null $parent
 * @method static NestableCollection<int, static> all($columns = ['*'])
 * @method static NestableCollection<int, static> get($columns = ['*'])
 * @method static Builder|WorkerPosition newModelQuery()
 * @method static Builder|WorkerPosition newQuery()
 * @method static Builder|WorkerPosition onlyTrashed()
 * @method static Builder|WorkerPosition query()
 * @method static Builder|WorkerPosition whereCreatedAt($value)
 * @method static Builder|WorkerPosition whereDeletedAt($value)
 * @method static Builder|WorkerPosition whereId($value)
 * @method static Builder|WorkerPosition whereParentId($value)
 * @method static Builder|WorkerPosition wherePositionName($value)
 * @method static Builder|WorkerPosition whereUpdatedAt($value)
 * @method static Builder|WorkerPosition withTrashed()
 * @method static Builder|WorkerPosition withoutTrashed()
 * @mixin Eloquent
 */
class WorkerPosition extends Model
{
    use HasFactory, NestableTrait, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'worker_positions';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'parent_id',
        'position_name'
    ];


    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function child(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }
}
