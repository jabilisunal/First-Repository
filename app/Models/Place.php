<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use App\Support\Eloquent\HasAddress;
use App\Traits\GlobalScope;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Place
 *
 * @property mixed $files
 * @property mixed $id
 * @property mixed $additional_images
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(array $array)
 * @property int $category_id
 * @property int $destination_id
 * @property string $slug
 * @property int $sort
 * @property int $status
 * @property int $is_popular
 * @property string $price
 * @property string|null $booking_url
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Address|null $address
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Category $category
 * @property-read Destination $destination
 * @property-read Collection<int, Facility> $facilities
 * @property-read int|null $facilities_count
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read \File $cover_image
 * @property-read float $rating
 * @property-read Collection<int, Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @property-read PlaceTranslation|null $translation
 * @property-read Collection<int, PlaceTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Place betweenPrice(array $priceArray = [])
 * @method static Builder|Place categoryFind(int $categoryId)
 * @method static Builder|Place destinationFind(int $destinationId)
 * @method static Builder|Place filter(array $filters = [])
 * @method static Builder|Place filterFacilities(array $facilitiesArray = [])
 * @method static Builder|Place listsTranslations(string $translationField)
 * @method static Builder|Place newModelQuery()
 * @method static Builder|Place newQuery()
 * @method static Builder|Place notTranslatedIn(?string $locale = null)
 * @method static Builder|Place onlyTrashed()
 * @method static Builder|Place orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Place orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Place orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Place query()
 * @method static Builder|Place titleSearch(?string $title = null)
 * @method static Builder|Place translated()
 * @method static Builder|Place translatedIn(?string $locale = null)
 * @method static Builder|Place whereBookingUrl($value)
 * @method static Builder|Place whereCategoryId($value)
 * @method static Builder|Place whereCreatedAt($value)
 * @method static Builder|Place whereDeletedAt($value)
 * @method static Builder|Place whereDestinationId($value)
 * @method static Builder|Place whereId($value)
 * @method static Builder|Place whereIsPopular($value)
 * @method static Builder|Place wherePrice($value)
 * @method static Builder|Place whereSlug($value)
 * @method static Builder|Place whereSort($value)
 * @method static Builder|Place whereStatus($value)
 * @method static Builder|Place whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Place whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Place whereUpdatedAt($value)
 * @method static Builder|Place withTranslation()
 * @method static Builder|Place withTrashed()
 * @method static Builder|Place withoutTrashed()
 * @mixin Eloquent
 */
class Place extends Model implements \Astrotomic\Translatable\Contracts\Translatable
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
    protected $table = 'places';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'slug',
        'category_id',
        'destination_id',
        'region_group_id',
        'sort',
        'status',
        'is_popular',
        'price',
        'booking_url',
    ];

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'place_id';

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'title',
        'why_choose_us',
        'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array $appends
     */
    protected $appends = [
        'rating',
        'base_image',
        'cover_image',
        'additional_images',
    ];

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
    public function regionGroup(): BelongsTo
    {
        return $this->belongsTo(RegionGroup::class, 'region_group_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class, 'destination_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        $entityType = get_class($this);

        return $this->hasMany(Review::class, 'model_id', 'id')
            ->where(['model_type' => $entityType]);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            PlaceTag::class,
            'tag_id',
            'place_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            Facility::class,
            PlaceFacility::class,
            'facility_id',
            'place_id'
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

    /**
     * @return float
     */
    public function getRatingAttribute(): float
    {

        $rating = 0;

        foreach ($this->reviews as $review) {
            $rating += $review->rating;
        }

        if ($rating > 0) {
            $rating = round($rating / $this->reviews->count(), 2);
        } else {
            $rating = 0.00;
        }

        return $rating;
    }
}
