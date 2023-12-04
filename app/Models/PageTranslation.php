<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PageTranslation
 *
 * @property int $id
 * @property int $page_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @method static Builder|PageTranslation newModelQuery()
 * @method static Builder|PageTranslation newQuery()
 * @method static Builder|PageTranslation query()
 * @method static Builder|PageTranslation whereDescription($value)
 * @method static Builder|PageTranslation whereId($value)
 * @method static Builder|PageTranslation whereLocale($value)
 * @method static Builder|PageTranslation wherePageId($value)
 * @method static Builder|PageTranslation whereTitle($value)
 * @mixin Eloquent
 */
class PageTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'page_translations';

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
