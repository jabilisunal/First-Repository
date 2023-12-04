<?php

namespace App\Models;

use App\Traits\HasFactoryOverride;
use Eloquent;
use Illuminate\Support\Carbon;
use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableAlias;
use Illuminate\Testing\Fluent\Concerns\Has;

/**
 * App\Models\Post
 *
 * @property mixed $files
 * @property mixed $id
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(int[] $array)
 * @property int $status
 * @property int $is_popular
 * @property int $sort
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read PostTranslation|null $translation
 * @property-read Collection<int, PostTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Post filter(array $filters = [])
 * @method static Builder|Post listsTranslations(string $translationField)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post notTranslatedIn(?string $locale = null)
 * @method static Builder|Post onlyTrashed()
 * @method static Builder|Post orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Post orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Post orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Post query()
 * @method static Builder|Post slug($value)
 * @method static Builder|Post translated()
 * @method static Builder|Post translatedIn(?string $locale = null)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDeletedAt($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereIsPopular($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereSort($value)
 * @method static Builder|Post whereStatus($value)
 * @method static Builder|Post whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Post whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static Builder|Post withTranslation()
 * @method static Builder|Post withTrashed()
 * @method static Builder|Post withoutTrashed()
 * @mixin Eloquent
 */
class Post extends Model implements TranslatableAlias
{
    use HasFactory, Translatable, Filterable, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'posts';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'post_id';


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'status',
        'is_popular',
        'slug',
        'sort',
        'created_at'
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
