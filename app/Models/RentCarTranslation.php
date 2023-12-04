<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RentCarTranslation
 *
 * @method static where(array $array)
 * @property int $id
 * @property int $rent_car_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $color
 * @property string|null $description
 * @method static Builder|RentCarTranslation newModelQuery()
 * @method static Builder|RentCarTranslation newQuery()
 * @method static Builder|RentCarTranslation query()
 * @method static Builder|RentCarTranslation whereColor($value)
 * @method static Builder|RentCarTranslation whereDescription($value)
 * @method static Builder|RentCarTranslation whereId($value)
 * @method static Builder|RentCarTranslation whereLocale($value)
 * @method static Builder|RentCarTranslation whereRentCarId($value)
 * @method static Builder|RentCarTranslation whereTitle($value)
 * @mixin Eloquent
 */
class RentCarTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'rent_car_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'color',
        'description'
    ];
}
