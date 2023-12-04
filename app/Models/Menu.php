<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use TypiCMS\NestableCollection;
use TypiCMS\NestableTrait;
use App\Support\Eloquent\HasMedia;
use App\Support\Eloquent\Filterable;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Menu
 *
 * @property mixed $files
 * @method static where(int[] $array)
 * @property int $id
 * @property int $menu_type_id
 * @property int|null $parent_id
 * @property string $slug
 * @property int $status
 * @property int $sort
 * @property string $style
 * @property int $target_blank
 * @property int $is_new
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read NestableCollection<int, Menu> $child
 * @property-read int|null $child_count
 * @property-read int|null $files_count
 * @property-read \File $base_image
 * @property-read Menu|null $parent
 * @property-read MenuTranslation|null $translation
 * @property-read Collection<int, MenuTranslation> $translations
 * @property-read int|null $translations_count
 * @method static NestableCollection<int, static> all($columns = ['*'])
 * @method static Builder|Menu filter(array $filters = [])
 * @method static NestableCollection<int, static> get($columns = ['*'])
 * @method static Builder|Menu listsTranslations(string $translationField)
 * @method static Builder|Menu menuType($value)
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu notTranslatedIn(?string $locale = null)
 * @method static Builder|Menu onlyTrashed()
 * @method static Builder|Menu orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Menu orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Menu orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static Builder|Menu query()
 * @method static Builder|Menu translated()
 * @method static Builder|Menu translatedIn(?string $locale = null)
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereDeletedAt($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereIsNew($value)
 * @method static Builder|Menu whereMenuTypeId($value)
 * @method static Builder|Menu whereParentId($value)
 * @method static Builder|Menu whereSlug($value)
 * @method static Builder|Menu whereSort($value)
 * @method static Builder|Menu whereStatus($value)
 * @method static Builder|Menu whereStyle($value)
 * @method static Builder|Menu whereTargetBlank($value)
 * @method static Builder|Menu whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static Builder|Menu whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @method static Builder|Menu withTranslation()
 * @method static Builder|Menu withTrashed()
 * @method static Builder|Menu withoutTrashed()
 * @mixin Eloquent
 */
class Menu extends Model implements \Astrotomic\Translatable\Contracts\Translatable
{
    use HasFactory, Translatable, NestableTrait, HasMedia, Filterable, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'menus';

    /**
     * @var string $translationForeignKey
     */
    protected $translationForeignKey = 'menu_id';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'menu_type_id',
        'parent_id',
        'slug',
        'status',
        'sort',
        'style',
        'is_new',
        'target_blank'
    ];

    /**
     * @var array|string[] $translatedAttributes
     */
    public array $translatedAttributes = [
        'title',
        'url'
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
    public function scopeMenuType($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->where('menu_type_id', (int)$value);
        });
    }
}
