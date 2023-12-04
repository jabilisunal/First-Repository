<?php

namespace App\Services;

use App\Repository\PageRepository;

class PageService extends AbstractService
{
    /**
     * @param \App\Repository\PageRepository $pageRepository
     */
    public function __construct(
        public PageRepository $pageRepository,
    ) {
        parent::__construct($pageRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getOneByParams(array $params): mixed
    {
        return $this->pageRepository->getOneByParams($params);
    }
}
