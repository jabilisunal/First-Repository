<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DestinationTranslation
 *
 * @property int $id
 * @property int $destination_id
 * @property string $locale
 * @property string|null $name
 * @property string|null $description
 * @method static Builder|DestinationTranslation newModelQuery()
 * @method static Builder|DestinationTranslation newQuery()
 * @method static Builder|DestinationTranslation query()
 * @method static Builder|DestinationTranslation whereDescription($value)
 * @method static Builder|DestinationTranslation whereDestinationId($value)
 * @method static Builder|DestinationTranslation whereId($value)
 * @method static Builder|DestinationTranslation whereLocale($value)
 * @method static Builder|DestinationTranslation whereName($value)
 * @mixin Eloquent
 */
class DestinationTranslation extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = 'destination_translations';

    /**
     * @var bool $timestamps
     */
    public $timestamps = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'name',
        'description',
    ];
}
