<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\FaqTranslation
 *
 * @property int $id
 * @property int $faq_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @method static Builder|FaqTranslation newModelQuery()
 * @method static Builder|FaqTranslation newQuery()
 * @method static Builder|FaqTranslation query()
 * @method static Builder|FaqTranslation whereDescription($value)
 * @method static Builder|FaqTranslation whereFaqId($value)
 * @method static Builder|FaqTranslation whereId($value)
 * @method static Builder|FaqTranslation whereLocale($value)
 * @method static Builder|FaqTranslation whereTitle($value)
 * @mixin Eloquent
 */
class FaqTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'faq_translations';

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
