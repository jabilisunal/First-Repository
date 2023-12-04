<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TourTranslation
 *
 * @method static where(array $array)
 * @property int $id
 * @property int $tour_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $why_choose_us
 * @property string|null $description
 * @method static Builder|TourTranslation newModelQuery()
 * @method static Builder|TourTranslation newQuery()
 * @method static Builder|TourTranslation query()
 * @method static Builder|TourTranslation whereDescription($value)
 * @method static Builder|TourTranslation whereId($value)
 * @method static Builder|TourTranslation whereLocale($value)
 * @method static Builder|TourTranslation whereTitle($value)
 * @method static Builder|TourTranslation whereTourId($value)
 * @method static Builder|TourTranslation whereWhyChooseUs($value)
 * @mixin Eloquent
 */
class TourTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'tour_translations';

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
