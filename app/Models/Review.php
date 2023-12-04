<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\Review
 *
 * @method static create(array $array)
 * @property int $id
 * @property int|null $model_id
 * @property string|null $model_type
 * @property int $rating
 * @property string $full_name
 * @property string $email
 * @property string|null $message
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|Review newModelQuery()
 * @method static Builder|Review newQuery()
 * @method static Builder|Review query()
 * @method static Builder|Review whereCreatedAt($value)
 * @method static Builder|Review whereDeletedAt($value)
 * @method static Builder|Review whereEmail($value)
 * @method static Builder|Review whereFullName($value)
 * @method static Builder|Review whereId($value)
 * @method static Builder|Review whereMessage($value)
 * @method static Builder|Review whereModelId($value)
 * @method static Builder|Review whereModelType($value)
 * @method static Builder|Review whereRating($value)
 * @method static Builder|Review whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Review extends Model
{
    use HasFactory;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'reviews';

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'id',
        'model_id',
        'model_type',
        'rating',
        'full_name',
        'email',
        'message',
    ];
}
