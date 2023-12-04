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
 * App\Models\Currency
 *
 * @method static where(int[] $array)
 * @method static truncate()
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $symbol
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Currency filter(array $filters = [])
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency onlyTrashed()
 * @method static Builder|Currency query()
 * @method static Builder|Currency status($value)
 * @method static Builder|Currency whereCode($value)
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereDeletedAt($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency whereName($value)
 * @method static Builder|Currency whereStatus($value)
 * @method static Builder|Currency whereSymbol($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 * @method static Builder|Currency withTrashed()
 * @method static Builder|Currency withoutTrashed()
 * @mixin Eloquent
 */
class Currency extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'currencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> $fillable
     */
    protected $fillable = [
        'id',
        'name',
        'code',
        'symbol',
        'status'
    ];

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
