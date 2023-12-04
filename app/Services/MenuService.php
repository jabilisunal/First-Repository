<?php

namespace App\Services;

use App\Repository\MenuRepository;

class MenuService extends AbstractService
{
    /**
     * @param MenuRepository $menuRepository
     */
    public function __construct(
        public MenuRepository $menuRepository,
    ) {
        parent::__construct($menuRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getListsByParams(array $params): mixed
    {
        return $this->menuRepository->getByParams($params)->get();
    }
}
