<?php

namespace App\Services;

use App\Repository\LanguageRepository;

class LanguageService extends AbstractService
{
    /**
     * @param LanguageRepository $languageRepository
     */
    public function __construct(
        public LanguageRepository $languageRepository,
    ) {
        parent::__construct($languageRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getListsByParams(array $params): mixed
    {
        return $this->languageRepository->getByParams($params)->get();
    }
}
