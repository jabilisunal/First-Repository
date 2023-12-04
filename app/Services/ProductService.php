<?php

namespace App\Services;

use App\Repository\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductService extends AbstractService
{
    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(
        public ProductRepository $productRepository,
    ) {
        parent::__construct($productRepository);
    }

    /**
     * @param array $params
     * @return Builder
     */
    public function getListsByParams(array $params): Builder
    {
        return $this->productRepository->getByParams($params);
    }

    public function getOneByParams(array $params) {
        return $this->productRepository->getOneByParams($params);
    }

    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function pagination(int $limit = 15): LengthAwarePaginator
    {
        return parent::pagination($limit);
    }
}
