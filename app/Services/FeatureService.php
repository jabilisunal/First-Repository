<?php

namespace App\Services;

use App\Repository\FeatureRepository;

class FeatureService extends AbstractService
{
    /**
     * @param FeatureRepository $featureRepository
     */
    public function __construct(
        public FeatureRepository $featureRepository,
    ) {
        parent::__construct($featureRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getListsByParams(array $params): mixed
    {
        return $this->featureRepository->getByParams($params)->get();
    }
}
