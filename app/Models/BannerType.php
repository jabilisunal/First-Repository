<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\BannerType
 *
 * @method static truncate()
 * @method static insert(string[][] $bannerTypes)
 * @property int $id
 * @property string|null $name
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Banner> $banners
 * @property-read int|null $banners_count
 * @method static Builder|BannerType newModelQuery()
 * @method static Builder|BannerType newQuery()
 * @method static Builder|BannerType onlyTrashed()
 * @method static Builder|BannerType query()
 * @method static Builder|BannerType whereCreatedAt($value)
 * @method static Builder|BannerType whereDeletedAt($value)
 * @method static Builder|BannerType whereId($value)
 * @method static Builder|BannerType whereName($value)
 * @method static Builder|BannerType whereUpdatedAt($value)
 * @method static Builder|BannerType withTrashed()
 * @method static Builder|BannerType withoutTrashed()
 * @mixin Eloquent
 */
class BannerType extends Model
{
    use HasFactory, SoftDeletes;
    public const SLIDER = 1;
    public const SLIDER_BOTTOM = 2;
    public const SPECIAL_OFFER = 3;
    public const NEWS_LETTER = 4;
    public const TRAVEL_TIPS = 5;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'banner_types';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * @return HasMany
     */
    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class, 'type_id', 'id');
    }
}
