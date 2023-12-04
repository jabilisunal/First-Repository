<?php

namespace App\Traits;

use Illuminate\Database\Query\Builder;

/**
 * @method static categoryFind(Builder $query, array $categoryId)
 * @method static destinationFind(Builder $query, array $destinationId)
 * @method static titleSearch(Builder $query, ?string $title)
 * @method static betweenPrice(Builder $query, array $priceArray)
 * @method static filterFacilities(Builder $query, array $priceArray)
 */
trait GlobalScope
{

    /**
     * @param $query
     * @param int $categoryId
     * @return mixed
     */
    public function scopeCategoryFind($query, int $categoryId): mixed
    {
        return $query->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        });
    }

    /**
     * @param $query
     * @param int $destinationId
     * @return mixed
     */
    public function scopeDestinationFind($query, int $destinationId): mixed
    {
        return $query->when($destinationId, function ($query) use ($destinationId) {
            $query->where('destination_id', $destinationId);
        });
    }

    /**
     * @param $query
     * @param int $regionGroupId
     * @return mixed
     */
    public function scopeRegionGroupFind($query, int $regionGroupId): mixed
    {
        return $query->when($regionGroupId, function ($query) use ($regionGroupId) {
            $query->where('region_group_id', $regionGroupId);
        });
    }

    /**
     * @param $query
     * @param string|null $title
     * @return mixed
     */
    public function scopeTitleSearch($query, string $title = null): mixed
    {
        return $query->when($title, function ($query) use ($title) {
            $query->whereHas('translations', function ($query) use ($title) {
                $query->where('title', 'LIKE', '%' . $title . '%');
            });
        });
    }

    /**
     * @param $query
     * @param array $priceArray
     * @return mixed
     */
    public function scopeBetweenPrice($query, array $priceArray = [0, 0]): mixed
    {
        return $query->when(($priceArray[0] > 0 && $priceArray[1] > 0), function ($query) use ($priceArray) {
            $query->whereBetween('price', [$priceArray[0], $priceArray[1]]);
        });
    }

    /**
     * @param $query
     * @param array $facilitiesArray
     * @return mixed
     */
    public function scopeFilterFacilities($query, array $facilitiesArray = []): mixed
    {
        return $query->when((count($facilitiesArray) > 0), function ($query) use ($facilitiesArray) {
            $query->whereHas('facilities', function ($query) use ($facilitiesArray) {
                $integerIDs = array_map('intval', $facilitiesArray);
                $query->whereIn('facility_id', $integerIDs);
            });
        });
    }
}
