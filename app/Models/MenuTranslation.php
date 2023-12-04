<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MenuTranslation
 *
 * @property int $id
 * @property int $menu_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $url
 * @method static Builder|MenuTranslation newModelQuery()
 * @method static Builder|MenuTranslation newQuery()
 * @method static Builder|MenuTranslation query()
 * @method static Builder|MenuTranslation whereId($value)
 * @method static Builder|MenuTranslation whereLocale($value)
 * @method static Builder|MenuTranslation whereMenuId($value)
 * @method static Builder|MenuTranslation whereTitle($value)
 * @method static Builder|MenuTranslation whereUrl($value)
 * @mixin Eloquent
 */
class MenuTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'menu_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'url',
    ];
}
