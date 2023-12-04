<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Banner
 *
 * @property mixed $files
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @property int $id
 * @property int $type_id
 * @property string $position
 * @property int $status
 * @property int $sort
 * @property string|null $effect
 * @property string|null $duration
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read Collection $additional_images
 * @property-read \File $base_image
 * @property-read BannerTranslation|null $translation
 * @property-read Collection<int, BannerTranslation> $translations
 * @property-read int|null $translations_count
 * @property-read BannerType|null $type
 * @method static Builder|Banner bannerType($value)
 * @method static Builder|Banner filter(array $filters = [])
 * @method static Builder|Banner listsTranslations(string $translationField)
 * @method static Builder|Banner newModelQuery()
 * @method static Builder|Banner newQuery()
 * @method static Builder|Banner notTranslatedIn(?string $locale = null)
 * @method static Builder|Banner onlyTrashed()
 * @method static Builder|Banner orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Banner orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Banner orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Banner query()
 * @method static Builder|Banner translated()
 * @method static Builder|Banner translatedIn(?string $locale = null)
 * @method static Builder|Banner whereCreatedAt($value)
 * @method static Builder|Banner whereDeletedAt($value)
 * @method static Builder|Banner whereDuration($value)
 * @method static Builder|Banner whereEffect($value)
 * @method static Builder|Banner whereId($value)
 * @method static Builder|Banner wherePosition($value)
 * @method static Builder|Banner whereSort($value)
 * @method static Builder|Banner whereStatus($value)
 * @method static Builder|Banner whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Banner whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Banner whereTypeId($value)
 * @method static Builder|Banner whereUpdatedAt($value)
 * @method static Builder|Banner withTranslation()
 * @method static Builder|Banner withTrashed()
 * @method static Builder|Banner withoutTrashed()
 * @mixin Eloquent
 */
class Banner extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, Filterable, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'banners';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'banner_id';


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'type_id',
        'effect',
        'position',
        'duration',
        'status',
        'sort'
    ];

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'title',
        'description',
        'button_title',
        'button_url',
        'button_icon'
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
            'filters' => [
                'title',
                'description',
                'status',
                'button_title',
                'button_url',
                'button_icon'
            ],
            'sorts' => ['created_at', 'sort']
        ];
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(BannerType::class, 'type_id', 'id');
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
            ->sortBy('pivot.id');
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeBannerType($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->where('type_id', (int) $value);
        });
    }
}
