<?php

namespace App\Models;

use App\Support\Eloquent\HasAddress;
use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use App\Traits\GlobalScope;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\RentCar
 *
 * @property mixed $files
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(array $array)
 * @property int $id
 * @property int $brand_id
 * @property int $category_id
 * @property int $destination_id
 * @property int $sort
 * @property int $is_popular
 * @property int $year
 * @property int $seats
 * @property string $engine_type
 * @property string $slug
 * @property int $status
 * @property string $daily_price
 * @property string $weekly_price
 * @property string $monthly_price
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Address|null $address
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Brand $brand
 * @property-read Category $category
 * @property-read Destination $destination
 * @property-read Collection<int, Facility> $facilities
 * @property-read int|null $facilities_count
 * @property-read int|null $files_count
 * @property-read Collection $additional_images
 * @property-read \File $base_image
 * @property-read \File $cover_image
 * @property-read Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @property-read RentCarTranslation|null $translation
 * @property-read Collection<int, RentCarTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|RentCar betweenPrice(array $priceArray = [])
 * @method static Builder|RentCar category(int $categoryId)
 * @method static Builder|RentCar destination(int $destinationId)
 * @method static Builder|RentCar filter(array $filters = [])
 * @method static Builder|RentCar filterFacilities(array $facilitiesArray = [])
 * @method static Builder|RentCar listsTranslations(string $translationField)
 * @method static Builder|RentCar newModelQuery()
 * @method static Builder|RentCar newQuery()
 * @method static Builder|RentCar notTranslatedIn(?string $locale = null)
 * @method static Builder|RentCar onlyTrashed()
 * @method static Builder|RentCar orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|RentCar orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|RentCar orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|RentCar query()
 * @method static Builder|RentCar titleSearch(?string $title = null)
 * @method static Builder|RentCar translated()
 * @method static Builder|RentCar translatedIn(?string $locale = null)
 * @method static Builder|RentCar whereBrandId($value)
 * @method static Builder|RentCar whereCategoryId($value)
 * @method static Builder|RentCar whereCreatedAt($value)
 * @method static Builder|RentCar whereDailyPrice($value)
 * @method static Builder|RentCar whereDeletedAt($value)
 * @method static Builder|RentCar whereDestinationId($value)
 * @method static Builder|RentCar whereEngineType($value)
 * @method static Builder|RentCar whereId($value)
 * @method static Builder|RentCar whereIsPopular($value)
 * @method static Builder|RentCar whereMonthlyPrice($value)
 * @method static Builder|RentCar whereSeats($value)
 * @method static Builder|RentCar whereSlug($value)
 * @method static Builder|RentCar whereSort($value)
 * @method static Builder|RentCar whereStatus($value)
 * @method static Builder|RentCar whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|RentCar whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|RentCar whereUpdatedAt($value)
 * @method static Builder|RentCar whereWeeklyPrice($value)
 * @method static Builder|RentCar whereYear($value)
 * @method static Builder|RentCar withTranslation()
 * @method static Builder|RentCar withTrashed()
 * @method static Builder|RentCar withoutTrashed()
 * @method static Builder|RentCar categoryFind(int $categoryId)
 * @method static Builder|RentCar destinationFind(int $destinationId)
 * @mixin Eloquent
 */
class RentCar extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory,
        Translatable,
        HasMedia,
        HasAddress,
        Filterable,
        GlobalScope,
        SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'rent_cars';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'slug',
        'brand_id',
        'category_id',
        'destination_id',
        'region_group_id',
        'year',
        'seats',
        'engine_type',
        'sort',
        'slug',
        'status',
        'is_popular',
        'daily_price',
        'weekly_price',
        'monthly_price',
    ];

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'rent_car_id';

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'title',
        'color',
        'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array $appends
     */
    protected $appends = [
        'base_image',
        'cover_image',
        'additional_images',
    ];


    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            RentCarTags::class,
            'tag_id',
            'rent_car_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            Facility::class,
            RentCarFacility::class,
            'facility_id',
            'rent_car_id'
        );
    }

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

    /**
     * Get the product's base image.
     *
     * @return File
     */
    public function getCoverImageAttribute(): File
    {
        return $this->files->where('pivot.zone', 'cover_image')->first() ?: new File;
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
            ->sortBy('pivot.id');
    }
}
