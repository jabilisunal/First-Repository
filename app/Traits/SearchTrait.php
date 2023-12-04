<?php

namespace App\Traits;

trait SearchTrait
{
    /**
     * @param $query
     * @param $column
     * @param $value
     */
    public function scopeSearch($query, $column, $value): void
    {
        $query->where($column,'ILIKE', '%' . $value . '%');
    }

    /**
     * @param $query
     * @param $column
     * @param $value
     */
    public function scopeOrSearch($query, $column, $value): void
    {
        $query->orWhere($column,'ILIKE', '%' . $value . '%');
    }
}
