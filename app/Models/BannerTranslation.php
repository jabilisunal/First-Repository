<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BannerTranslation
 *
 * @property int $id
 * @property int $banner_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @property string|null $button_title
 * @property string|null $button_url
 * @property string|null $button_icon
 * @method static Builder|BannerTranslation newModelQuery()
 * @method static Builder|BannerTranslation newQuery()
 * @method static Builder|BannerTranslation query()
 * @method static Builder|BannerTranslation whereBannerId($value)
 * @method static Builder|BannerTranslation whereButtonIcon($value)
 * @method static Builder|BannerTranslation whereButtonTitle($value)
 * @method static Builder|BannerTranslation whereButtonUrl($value)
 * @method static Builder|BannerTranslation whereDescription($value)
 * @method static Builder|BannerTranslation whereId($value)
 * @method static Builder|BannerTranslation whereLocale($value)
 * @method static Builder|BannerTranslation whereTitle($value)
 * @mixin Eloquent
 */
class BannerTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'banner_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'description',
        'button_title',
        'button_url',
        'button_icon'
    ];
}
