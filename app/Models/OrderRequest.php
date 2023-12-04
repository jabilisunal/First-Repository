<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class OrderRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = "mysql";

    /**
     * @var string $table
     */
    protected $table = "order_requests";

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'model_id',
        'model_type',
        'name',
        'surname',
        'phone',
        'email',
        'message',
        'start_date',
        'end_date'
    ];
}
