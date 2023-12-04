<?php

namespace App\Models;

use App\Support\Eloquent\Filterable;
use App\Support\Eloquent\HasMedia;
use Astrotomic\Translatable\Translatable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Facility
 *
 * @method static truncate()
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(int[] $array)
 * @property mixed $files
 * @property int $id
 * @property int $type
 * @property int $sort
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read FacilityTranslation|null $translation
 * @property-read Collection<int, FacilityTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Facility filter(array $filters = [])
 * @method static Builder|Facility listsTranslations(string $translationField)
 * @method static Builder|Facility newModelQuery()
 * @method static Builder|Facility newQuery()
 * @method static Builder|Facility notTranslatedIn(?string $locale = null)
 * @method static Builder|Facility onlyTrashed()
 * @method static Builder|Facility orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Facility orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Facility orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Facility query()
 * @method static Builder|Facility translated()
 * @method static Builder|Facility translatedIn(?string $locale = null)
 * @method static Builder|Facility whereCreatedAt($value)
 * @method static Builder|Facility whereDeletedAt($value)
 * @method static Builder|Facility whereId($value)
 * @method static Builder|Facility whereSort($value)
 * @method static Builder|Facility whereStatus($value)
 * @method static Builder|Facility whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Facility whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Facility whereType($value)
 * @method static Builder|Facility whereUpdatedAt($value)
 * @method static Builder|Facility withTranslation()
 * @method static Builder|Facility withTrashed()
 * @method static Builder|Facility withoutTrashed()
 * @mixin Eloquent
 */
class Facility extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
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

    use HasFactory, Translatable, HasMedia, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'facilities';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'facility_id';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'type',
        'status',
        'sort'
    ];

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'name'
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
