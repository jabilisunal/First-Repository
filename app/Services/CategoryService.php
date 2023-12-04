<?php

namespace App\Services;

use App\Repository\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService extends AbstractService
{
    /**
     * @param \App\Repository\CategoryRepository $categoryRepository
     */
    public function __construct(
        public CategoryRepository $categoryRepository,
    ) {
        parent::__construct($categoryRepository);
    }

    /**
     * @param array $params
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getListsByParams(array $params): array|Collection
    {
        return $this->categoryRepository->getByParams($params)->get();
    }
}
