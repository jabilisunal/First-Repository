<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PlaceTranslation
 *
 * @method static where(array $array)
 * @property int $id
 * @property int $place_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $why_choose_us
 * @property string|null $description
 * @method static Builder|PlaceTranslation newModelQuery()
 * @method static Builder|PlaceTranslation newQuery()
 * @method static Builder|PlaceTranslation query()
 * @method static Builder|PlaceTranslation whereDescription($value)
 * @method static Builder|PlaceTranslation whereId($value)
 * @method static Builder|PlaceTranslation whereLocale($value)
 * @method static Builder|PlaceTranslation wherePlaceId($value)
 * @method static Builder|PlaceTranslation whereTitle($value)
 * @method static Builder|PlaceTranslation whereWhyChooseUs($value)
 * @mixin Eloquent
 */
class PlaceTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'place_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'why_choose_us',
        'description'
    ];
}
