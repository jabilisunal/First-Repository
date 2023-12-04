<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\FeatureTranslation
 *
 * @property int $id
 * @property int $feature_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @method static Builder|FeatureTranslation newModelQuery()
 * @method static Builder|FeatureTranslation newQuery()
 * @method static Builder|FeatureTranslation query()
 * @method static Builder|FeatureTranslation whereDescription($value)
 * @method static Builder|FeatureTranslation whereFeatureId($value)
 * @method static Builder|FeatureTranslation whereId($value)
 * @method static Builder|FeatureTranslation whereLocale($value)
 * @method static Builder|FeatureTranslation whereTitle($value)
 * @mixin Eloquent
 */
class FeatureTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'feature_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'description'
    ];
}
