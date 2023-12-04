<?php

namespace App\Models;

use App\Support\Eloquent\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


/**
 * App\Models\Language
 *
 * @method static insert(array[] $languages)
 * @method static truncate()
 * @method static where(mixed $param)
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $code
 * @property string $style
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Language filter(array $filters = [])
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language onlyTrashed()
 * @method static Builder|Language query()
 * @method static Builder|Language status($value)
 * @method static Builder|Language whereCode($value)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereDeletedAt($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereName($value)
 * @method static Builder|Language whereShortName($value)
 * @method static Builder|Language whereStatus($value)
 * @method static Builder|Language whereStyle($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @method static Builder|Language withTrashed()
 * @method static Builder|Language withoutTrashed()
 * @mixin Eloquent
 */
class Language extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'id',
        'name',
        'short_name',
        'code',
        'style',
        'status'
    ];

    /**
     * @return string[][]
     */
    public function getFilters(): array
    {
        return [
            'includes' => [],
            'filters' => ['name', 'code'],
            'sorts' => ['created_at']
        ];
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeStatus($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->where('status', $value);
        });
    }
}
