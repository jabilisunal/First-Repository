<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Page
 *
 * @property mixed $files
 * @method static where(array $array)
 * @property int $id
 * @property int $status
 * @property int $sort
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read PageTranslation|null $translation
 * @property-read Collection<int, PageTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Page filter(array $filters = [])
 * @method static Builder|Page listsTranslations(string $translationField)
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page notTranslatedIn(?string $locale = null)
 * @method static Builder|Page onlyTrashed()
 * @method static Builder|Page orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Page orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Page orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Page query()
 * @method static Builder|Page slug($value)
 * @method static Builder|Page translated()
 * @method static Builder|Page translatedIn(?string $locale = null)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDeletedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereSort($value)
 * @method static Builder|Page whereStatus($value)
 * @method static Builder|Page whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Page whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page withTranslation()
 * @method static Builder|Page withTrashed()
 * @method static Builder|Page withoutTrashed()
 * @mixin Eloquent
 */
class Page extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, Filterable, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'pages';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'page_id';


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'status',
        'slug',
        'sort'
    ];

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'title',
        'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array $appends
     */
    protected $appends = [
        'base_image'
    ];

    /**
     * @return string[][]
     */
    public function getFilters(): array
    {
        return [
            'includes' => [],
            'filters' => ['title', 'description', 'status'],
            'sorts' => ['created_at', 'sort']
        ];
    }

    /**
     * Get the product's base image.
     *
     * @return File
     */
    public function getBaseImageAttribute(): File
    {
        return $this->files->where('pivot.zone', 'base_image')->first() ?: new File;
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeSlug($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->where('slug', $value);
        });
    }
}
