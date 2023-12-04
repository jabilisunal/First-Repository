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
 * App\Models\Faq
 *
 * @property mixed $files
 * @method static where(int[] $array)
 * @property int $id
 * @property int $status
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read FaqTranslation|null $translation
 * @property-read Collection<int, FaqTranslation> $translations
 * @property-read int|null $translations_count
 * @method static Builder|Faq filter(array $filters = [])
 * @method static Builder|Faq listsTranslations(string $translationField)
 * @method static Builder|Faq newModelQuery()
 * @method static Builder|Faq newQuery()
 * @method static Builder|Faq notTranslatedIn(?string $locale = null)
 * @method static Builder|Faq onlyTrashed()
 * @method static Builder|Faq orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Faq orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Faq orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Faq query()
 * @method static Builder|Faq translated()
 * @method static Builder|Faq translatedIn(?string $locale = null)
 * @method static Builder|Faq whereCreatedAt($value)
 * @method static Builder|Faq whereDeletedAt($value)
 * @method static Builder|Faq whereId($value)
 * @method static Builder|Faq whereSort($value)
 * @method static Builder|Faq whereStatus($value)
 * @method static Builder|Faq whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Faq whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Faq whereUpdatedAt($value)
 * @method static Builder|Faq withTranslation()
 * @method static Builder|Faq withTrashed()
 * @method static Builder|Faq withoutTrashed()
 * @mixin Eloquent
 */
class Faq extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, Filterable, HasMedia, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'faqs';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'faq_id';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
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
}
