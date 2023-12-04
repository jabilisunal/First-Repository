<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BrandTranslation
 *
 * @property int $id
 * @property int $brand_id
 * @property string $locale
 * @property string|null $title
 * @method static Builder|BrandTranslation newModelQuery()
 * @method static Builder|BrandTranslation newQuery()
 * @method static Builder|BrandTranslation query()
 * @method static Builder|BrandTranslation whereBrandId($value)
 * @method static Builder|BrandTranslation whereId($value)
 * @method static Builder|BrandTranslation whereLocale($value)
 * @method static Builder|BrandTranslation whereTitle($value)
 * @mixin Eloquent
 */
class BrandTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'brand_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title'
    ];
}
