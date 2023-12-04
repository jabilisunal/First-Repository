<?php

namespace App\Services;

use App\Repository\BannerRepository;

class BannerService extends AbstractService
{
    /**
     * @param BannerRepository $bannerRepository
     */
    public function __construct(
        public BannerRepository $bannerRepository,
    ) {
        parent::__construct($bannerRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getListsByParams(array $params): mixed
    {
        return $this->bannerRepository->getByParams($params)->get();
    }
}
