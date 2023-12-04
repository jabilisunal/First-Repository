<?php

namespace App\Support\Eloquent;

use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method hasOne(string $class, string $string, string $string1)
 * @method hasMany(string $class, string $string, string $string1)
 */
trait HasAddress
{
    /**
     * @return HasOne
     */
    public function address(): HasOne
    {
        $entityType = get_class($this);

        return $this->hasOne(Address::class, 'model_id', 'id')
            ->where(['model_type' => $entityType])->orderBy('sort', 'DESC');
    }

    /**
     * @return HasMany
     */
    public function addresses(): HasMany
    {
        $entityType = get_class($this);

        return $this->hasMany(Address::class, 'model_id', 'id')
            ->where(['model_type' => $entityType]);
    }
}
