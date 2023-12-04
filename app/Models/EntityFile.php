<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\EntityFile
 *
 * @property int $id
 * @property int $file_id
 * @property string|null $entity_type
 * @property int $entity_id
 * @property string|null $zone
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|EntityFile newModelQuery()
 * @method static Builder|EntityFile newQuery()
 * @method static Builder|EntityFile onlyTrashed()
 * @method static Builder|EntityFile query()
 * @method static Builder|EntityFile whereCreatedAt($value)
 * @method static Builder|EntityFile whereDeletedAt($value)
 * @method static Builder|EntityFile whereEntityId($value)
 * @method static Builder|EntityFile whereEntityType($value)
 * @method static Builder|EntityFile whereFileId($value)
 * @method static Builder|EntityFile whereId($value)
 * @method static Builder|EntityFile whereUpdatedAt($value)
 * @method static Builder|EntityFile whereZone($value)
 * @method static Builder|EntityFile withTrashed()
 * @method static Builder|EntityFile withoutTrashed()
 * @mixin Eloquent
 */
class EntityFile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'entity_files';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'file_id',
        'entity_type',
        'entity_id',
        'zone'
    ];
}
