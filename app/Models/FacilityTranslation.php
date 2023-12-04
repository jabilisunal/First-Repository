<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FacilityTranslation
 *
 * @property int $id
 * @property int $facility_id
 * @property string $locale
 * @property string|null $name
 * @method static Builder|FacilityTranslation newModelQuery()
 * @method static Builder|FacilityTranslation newQuery()
 * @method static Builder|FacilityTranslation query()
 * @method static Builder|FacilityTranslation whereFacilityId($value)
 * @method static Builder|FacilityTranslation whereId($value)
 * @method static Builder|FacilityTranslation whereLocale($value)
 * @method static Builder|FacilityTranslation whereName($value)
 * @mixin Eloquent
 */
class FacilityTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'facility_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'name'
    ];
}
