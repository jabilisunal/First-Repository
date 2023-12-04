<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CategoryTranslation
 *
 * @method static truncate()
 * @method static create(array $translateValue)
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @method static Builder|CategoryTranslation newModelQuery()
 * @method static Builder|CategoryTranslation newQuery()
 * @method static Builder|CategoryTranslation query()
 * @method static Builder|CategoryTranslation whereCategoryId($value)
 * @method static Builder|CategoryTranslation whereDescription($value)
 * @method static Builder|CategoryTranslation whereId($value)
 * @method static Builder|CategoryTranslation whereLocale($value)
 * @method static Builder|CategoryTranslation whereTitle($value)
 * @mixin Eloquent
 */
class CategoryTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'category_translations';

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
