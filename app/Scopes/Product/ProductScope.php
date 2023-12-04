<?php

namespace App\Scopes\Product;

trait ProductScope {

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeTaxes($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->whereIn('tax_id', $value);
        });
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeBrands($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->whereIn('brand_id', $value);
        });
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeSlug($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->where('slug', $value);
        });
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeCategories($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->whereHas('categories', static function ($query) use ($value) {
                $query->whereIn('category_id', $value);
            });
        });
    }

    /**
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeTags($query, $value): mixed
    {
        return $query->when($value, function ($query) use ($value) {
            return $query->whereHas('tags', static function ($query) use ($value) {
                $query->whereIn('tag_id', $value);
            });
        });
    }

}