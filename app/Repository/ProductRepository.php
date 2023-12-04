<?php

namespace App\Repository;


use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HigherOrderWhenProxy;

class ProductRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $params
     * @return Builder
     */
    public function getByParams(array $params): Builder
    {
        return $this->buildQuery()
            ->select($this->selectedColumnsForList())
            ->with([
                'variant' => function ($query) {
                    $query->where(['is_default' => 1]);
                },
                'variants',
                'reviews',
                'tags',
                'brand',
                'categories',
                'options'
            ])
            ->when(isset($params['brands']), function ($q) use ($params) {
                $q->brands($params['brands']);
            })
            ->when(isset($params['taxes']), function ($q) use ($params) {
                $q->taxes($params['taxes']);
            })
            ->when(isset($params['categories']), function ($q) use ($params) {
                $q->categories($params['categories']);
            })
            ->when(isset($params['tags']), function ($q) use ($params) {
                $q->tags($params['tags']);
            })
            ->when(isset($params['is_selected']), function ($q) use ($params) {
                $q->where('is_selected', (int)$params['is_selected']);
            })
            ->when(isset($params['is_new']), function ($q) use ($params) {
                $q->where('is_new', (int)$params['is_new']);
            })
            ->when(isset($params['is_best_seller']), function ($q) use ($params) {
                $q->where('is_best_seller', (int)$params['is_best_seller']);
            })
            ->when(isset($params['limit']), function ($q) use ($params) {
                $q->limit((int) $params['limit']);
            })
            ->when(isset($params['min_price'], $params['max_price']), function ($q) use ($params) {
                if (($params['min_price'] < $params['max_price']) && $params['min_price'] > 0 && $params['max_price'] > 0) {
                    $q->whereHas('variants', static function ($q) use ($params) {
                        $q->whereBetween('new_tax_price', [
                            (int) $params['min_price'],
                            (int) $params['max_price']
                        ]);
                    });
                }
            })
            ->when(isset($params['sort_field'], $params['sort_value']), function ($q) use ($params) {
                if (
                    in_array(strtolower($params['sort_field']), ["created_at", "sort"]) &&
                    in_array(strtolower($params['sort_value']), ["ASC", "DESC"])
                ) {
                    $q->orderBy($params['sort_field'], $params['sort_value']);
                } else {
                    $q->orderBy("sort", "desc");
                }
            });
    }


    /**
     * @param array $params
     * @return mixed
     */
    public function getOneByParams(array $params): mixed
    {
        return $this->buildQuery()
            ->select($this->selectedColumnsForList())
            ->with([
                'variant' => function ($query) use ($params) {
                    if (isset($params['variant_id'])) {
                        $query->where(['id' => (int) $params['variant_id']]);
                    } else {
                        $query->where(['is_default' => 1]);
                    }
                },
                'variants',
                'reviews',
                'tags',
                'brand',
                'categories',
                'options'
            ])
            ->when(isset($params['slug']), function ($q) use ($params) {
                $q->slug($params['slug']);
            });
    }

    /**
     * @return string[]
     */
    public function selectedColumnsForList(): array
    {
        return [
            'id',
            'brand_id',
            'tax_id',
            'sort',
            'status',
            'slug',
            'is_new',
            'is_best_seller'
        ];
    }
}
