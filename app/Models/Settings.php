<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Settings
 *
 * @method static create(array $array)
 * @method static whereName($key)
 * @method static insert(array[] $settings)
 * @method static truncate()
 * @property int $id
 * @property string $name
 * @property string $val
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Settings newModelQuery()
 * @method static Builder|Settings newQuery()
 * @method static Builder|Settings onlyTrashed()
 * @method static Builder|Settings query()
 * @method static Builder|Settings whereCreatedAt($value)
 * @method static Builder|Settings whereDeletedAt($value)
 * @method static Builder|Settings whereId($value)
 * @method static Builder|Settings whereType($value)
 * @method static Builder|Settings whereUpdatedAt($value)
 * @method static Builder|Settings whereVal($value)
 * @method static Builder|Settings withTrashed()
 * @method static Builder|Settings withoutTrashed()
 * @mixin Eloquent
 */
class Settings extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'settings';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'val',
        'type'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updated(static function () {
            self::flushCache();
        });

        static::created(static function () {
            self::flushCache();
        });
    }

    /**
     * Add a settings value
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function add($key, $val, string $type = 'string'): bool
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }

        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Get a settings value
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public static function get($key, $default = null): mixed
    {
        if (self::has($key)) {
            $setting = self::getAllSettings()->where('name', $key)->first();
            return self::castValue($setting->val, $setting->type);
        }

        return self::getDefaultValue($key, $default);
    }

    /**
     * Set a value for setting
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function set($key, $val, string $type = 'string'): bool
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update([
                'name' => $key,
                'val' => $val,
                'type' => $type]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a setting
     *
     * @param $key
     * @return bool
     */
    public static function remove($key): bool
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key): bool
    {
        return (boolean)self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Get the validation rules for setting fields
     *
     * @return array
     */
    public static function getValidationRules(): array
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Get the data type of setting
     *
     * @param $field
     * @return mixed
     */
    public static function getDataType($field): mixed
    {
        $type = self::getDefinedSettingFields()
            ->pluck('data', 'name')
            ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get default value for a setting
     *
     * @param $field
     * @return mixed
     */
    public static function getDefaultValueForField($field): mixed
    {
        return self::getDefinedSettingFields()
            ->pluck('value', 'name')
            ->get($field);
    }

    /**
     * Get default value from config if no value passed
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    private static function getDefaultValue($key, $default): mixed
    {
        return is_null($default) ? self::getDefaultValueForField($key) : $default;
    }

    /**
     * Get all the settings fields from config
     *
     * @return Collection
     */
    private static function getDefinedSettingFields(): Collection
    {
        return collect(config('setting_fields'))->pluck('elements')->flatten(1);
    }

    /**
     * caste value into respective type
     *
     * @param $val
     * @param $castTo
     * @return bool|int|string
     */
    private static function castValue($val, $castTo): bool|int|string
    {
        return match ($castTo) {
            'int', 'integer' => (int)$val,
            'bool', 'boolean' => (bool)$val,
            default => $val,
        };
    }

    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getAllSettings(): mixed
    {
        return Cache::rememberForever('settings.all', static function () {
            return self::all();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache(): void
    {
        Cache::forget('settings.all');
    }
}
