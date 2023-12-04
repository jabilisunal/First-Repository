<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use TypiCMS\NestableCollection;
use TypiCMS\NestableTrait;
use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Category
 *
 * @method static whereNull(string $string)
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(int[] $array)
 * @method static truncate()
 * @property mixed $files
 * @property mixed $parent
 * @property mixed $child
 * @property mixed $id
 * @property mixed $title
 * @property mixed $slug
 * @property mixed $base_image
 * @property int|null $parent_id
 * @property string|null $color
 * @property int $status
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Brand> $brands
 * @property-read int|null $brands_count
 * @property-read int|null $child_count
 * @property-read int|null $files_count
 * @property-read Collection $additional_images
 * @property-read CategoryTranslation|null $translation
 * @property-read Collection<int, CategoryTranslation> $translations
 * @property-read int|null $translations_count
 * @method static NestableCollection<int, static> all($columns = ['*'])
 * @method static Builder|Category filter(array $filters = [])
 * @method static NestableCollection<int, static> get($columns = ['*'])
 * @method static Builder|Category listsTranslations(string $translationField)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category notTranslatedIn(?string $locale = null)
 * @method static Builder|Category onlyTrashed()
 * @method static Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Category parent(?int $value)
 * @method static Builder|Category query()
 * @method static Builder|Category translated()
 * @method static Builder|Category translatedIn(?string $locale = null)
 * @method static Builder|Category whereColor($value)
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereSort($value)
 * @method static Builder|Category whereStatus($value)
 * @method static Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category withTranslation()
 * @method static Builder|Category withTrashed()
 * @method static Builder|Category withoutTrashed()
 * @mixin Eloquent
 */
class Category extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, NestableTrait, HasMedia, Filterable, SoftDeletes;

    public const HOTEl = 1;
    public const APARTMENT = 2;
    public const RESTAURANT = 3;
    public const TOUR = 4;
    public const RENT_CAR = 5;

    public const TYPES = [
        self::HOTEl => 'Hotel',
        self::APARTMENT => 'Apartment',
        self::RESTAURANT => 'Restaurant',
        self::TOUR => 'Tour',
        self::RENT_CAR => 'Rent Car',
    ];

    public const PLACE_TYPES = [
        self::HOTEl,
        self::APARTMENT,
        self::RESTAURANT,
    ];

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'categories';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'category_id';


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'parent_id',
        'slug',
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
        'base_image',
        'additional_images',
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
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function child(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class,
            'category_brands',
            'category_id',
            'brand_id'
        );
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
     * Get product's additional images.
     *
     * @return Collection
     */
    public function getAdditionalImagesAttribute(): Collection
    {
        return $this->files
            ->where('pivot.zone', 'additional_images')
            ->sortBy('pivot.id') ?: collect([new File]);
    }

    /**
     * @param $query
     * @param int|null $value
     * @return mixed
     */
    public function scopeParent($query, ?int $value): mixed
    {
        return $query->where('parent_id', $value);
    }
}
