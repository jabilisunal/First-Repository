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
 * App\Models\Tour
 *
 * @property mixed $files
 * @property mixed $reviews
 * @property mixed $additional_images
 * @method static findOrFail(int $id)
 * @method static create(array $data)
 * @method static where(array $array)
 * @property int $id
 * @property int $category_id
 * @property int $destination_id
 * @property string $slug
 * @property int $sort
 * @property int $status
 * @property int $is_popular
 * @property string $price
 * @property string|null $start_date
 * @property string|null $end_date
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
 * @property-read int|null $reviews_count
 * @property-read Collection<int, Tag> $tags
 * @property-read int|null $tags_count
 * @property-read TourTranslation|null $translation
 * @property-read Collection<int, TourTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Tour betweenPrice(array $priceArray = [])
 * @method static Builder|Tour category(int $categoryId)
 * @method static Builder|Tour destination(int $destinationId)
 * @method static Builder|Tour filter(array $filters = [])
 * @method static Builder|Tour filterFacilities(array $facilitiesArray = [])
 * @method static Builder|Tour listsTranslations(string $translationField)
 * @method static Builder|Tour newModelQuery()
 * @method static Builder|Tour newQuery()
 * @method static Builder|Tour notTranslatedIn(?string $locale = null)
 * @method static Builder|Tour onlyTrashed()
 * @method static Builder|Tour orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Tour orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Tour orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Tour query()
 * @method static Builder|Tour titleSearch(?string $title = null)
 * @method static Builder|Tour translated()
 * @method static Builder|Tour translatedIn(?string $locale = null)
 * @method static Builder|Tour whereCategoryId($value)
 * @method static Builder|Tour whereCreatedAt($value)
 * @method static Builder|Tour whereDeletedAt($value)
 * @method static Builder|Tour whereDestinationId($value)
 * @method static Builder|Tour whereEndDate($value)
 * @method static Builder|Tour whereId($value)
 * @method static Builder|Tour whereIsPopular($value)
 * @method static Builder|Tour wherePrice($value)
 * @method static Builder|Tour whereSlug($value)
 * @method static Builder|Tour whereSort($value)
 * @method static Builder|Tour whereStartDate($value)
 * @method static Builder|Tour whereStatus($value)
 * @method static Builder|Tour whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Tour whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Tour whereUpdatedAt($value)
 * @method static Builder|Tour withTranslation()
 * @method static Builder|Tour withTrashed()
 * @method static Builder|Tour withoutTrashed()
 * @method static Builder|Tour categoryFind(int $categoryId)
 * @method static Builder|Tour destinationFind(int $destinationId)
 * @mixin Eloquent
 */
class Tour extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory,
        Translatable,
        HasMedia,
        HasAddress,
        Filterable,
        SoftDeletes,
        GlobalScope;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'tours';

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
        'start_date',
        'end_date'
    ];

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'tour_id';

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
    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(
            Facility::class,
            TourFacility::class,
            'facility_id',
            'tour_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            TourTag::class,
            'tag_id',
            'tour_id'
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
