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
 * App\Models\Brand
 *
 * @property mixed $files
 * @property mixed $id
 * @property mixed $slug
 * @property mixed $base_image
 * @property mixed $description
 * @property mixed $title
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(int[] $array)
 * @property int $status
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read BrandTranslation|null $translation
 * @property-read Collection<int, BrandTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Brand filter(array $filters = [])
 * @method static Builder|Brand listsTranslations(string $translationField)
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand notTranslatedIn(?string $locale = null)
 * @method static Builder|Brand onlyTrashed()
 * @method static Builder|Brand orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Brand query()
 * @method static Builder|Brand translated()
 * @method static Builder|Brand translatedIn(?string $locale = null)
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereDeletedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereSlug($value)
 * @method static Builder|Brand whereSort($value)
 * @method static Builder|Brand whereStatus($value)
 * @method static Builder|Brand whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Brand whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @method static Builder|Brand withTranslation()
 * @method static Builder|Brand withTrashed()
 * @method static Builder|Brand withoutTrashed()
 * @mixin Eloquent
 */
class Brand extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, HasMedia, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'brands';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'brand_id';


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'slug',
        'status',
        'sort'
    ];

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'title'
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
            'filters' => ['title'],
            'sorts' => ['created_at']
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
}
