<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PostTranslation
 *
 * @property int $id
 * @property int $post_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @method static Builder|PostTranslation newModelQuery()
 * @method static Builder|PostTranslation newQuery()
 * @method static Builder|PostTranslation query()
 * @method static Builder|PostTranslation whereDescription($value)
 * @method static Builder|PostTranslation whereId($value)
 * @method static Builder|PostTranslation whereLocale($value)
 * @method static Builder|PostTranslation wherePostId($value)
 * @method static Builder|PostTranslation whereTitle($value)
 * @mixin Eloquent
 */
class PostTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'post_translations';

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
