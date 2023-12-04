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
 * App\Models\Feature
 *
 * @method static where(int[] $array)
 * @property mixed $files
 * @property int $id
 * @property int $status
 * @property int $type
 * @property int $sort
 * @property string $color
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read FeatureTranslation|null $translation
 * @property-read Collection<int, FeatureTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Feature filter(array $filters = [])
 * @method static Builder|Feature listsTranslations(string $translationField)
 * @method static Builder|Feature newModelQuery()
 * @method static Builder|Feature newQuery()
 * @method static Builder|Feature notTranslatedIn(?string $locale = null)
 * @method static Builder|Feature onlyTrashed()
 * @method static Builder|Feature orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Feature orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Feature orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Feature query()
 * @method static Builder|Feature translated()
 * @method static Builder|Feature translatedIn(?string $locale = null)
 * @method static Builder|Feature type($value)
 * @method static Builder|Feature whereColor($value)
 * @method static Builder|Feature whereCreatedAt($value)
 * @method static Builder|Feature whereDeletedAt($value)
 * @method static Builder|Feature whereId($value)
 * @method static Builder|Feature whereSort($value)
 * @method static Builder|Feature whereStatus($value)
 * @method static Builder|Feature whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Feature whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Feature whereType($value)
 * @method static Builder|Feature whereUpdatedAt($value)
 * @method static Builder|Feature withTranslation()
 * @method static Builder|Feature withTrashed()
 * @method static Builder|Feature withoutTrashed()
 * @mixin Eloquent
 */
class Feature extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, Filterable, HasMedia, SoftDeletes;

    public const HOME = 0;
    public const PRODUCT = 1;
    public const TYPES = [
        self::HOME,
        self::PRODUCT
    ];

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'features';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'feature_id';


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'type',
        'color',
        'status',
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
    public function scopeType($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->where('type', (int)$value);
        });
    }
}
