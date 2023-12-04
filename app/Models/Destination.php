<?php

namespace App\Models;

use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\Destination
 *
 * @method static truncate()
 * @method static create(array $data)
 * @method static findOrFail(int $id)
 * @method static where(int[] $array)
 * @property mixed $files
 * @property int $id
 * @property string $slug
 * @property int $sort
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read DestinationTranslation|null $translation
 * @property-read Collection<int, DestinationTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Destination filter(array $filters = [])
 * @method static Builder|Destination listsTranslations(string $translationField)
 * @method static Builder|Destination newModelQuery()
 * @method static Builder|Destination newQuery()
 * @method static Builder|Destination notTranslatedIn(?string $locale = null)
 * @method static Builder|Destination onlyTrashed()
 * @method static Builder|Destination orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Destination orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Destination orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Destination query()
 * @method static Builder|Destination translated()
 * @method static Builder|Destination translatedIn(?string $locale = null)
 * @method static Builder|Destination whereCreatedAt($value)
 * @method static Builder|Destination whereDeletedAt($value)
 * @method static Builder|Destination whereId($value)
 * @method static Builder|Destination whereSlug($value)
 * @method static Builder|Destination whereSort($value)
 * @method static Builder|Destination whereStatus($value)
 * @method static Builder|Destination whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Destination whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Destination whereUpdatedAt($value)
 * @method static Builder|Destination withTranslation()
 * @method static Builder|Destination withTrashed()
 * @method static Builder|Destination withoutTrashed()
 * @mixin Eloquent
 */
class Destination extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, HasMedia, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'destinations';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'destination_id';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'slug',
        'status',
        'sort',
    ];

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'name',
        'description',
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
            'filters' => ['name'],
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
