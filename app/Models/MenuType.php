<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\MenuType
 *
 * @method static truncate()
 * @method static insert(array[] $menuTypes)
 * @property int $id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|MenuType newModelQuery()
 * @method static Builder|MenuType newQuery()
 * @method static Builder|MenuType onlyTrashed()
 * @method static Builder|MenuType query()
 * @method static Builder|MenuType whereCreatedAt($value)
 * @method static Builder|MenuType whereDeletedAt($value)
 * @method static Builder|MenuType whereId($value)
 * @method static Builder|MenuType whereTitle($value)
 * @method static Builder|MenuType whereUpdatedAt($value)
 * @method static Builder|MenuType withTrashed()
 * @method static Builder|MenuType withoutTrashed()
 * @mixin Eloquent
 */
class MenuType extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";
    /**
     * @var string $table
     */
    protected $table = 'menu_types';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'title'
    ];
}
