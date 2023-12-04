<?php

namespace App\Services;

use App\Repository\CurrencyRepository;

class CurrencyService extends AbstractService
{
    /**
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(
        public CurrencyRepository $currencyRepository,
    ) {
        parent::__construct($currencyRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getListsByParams(array $params): mixed
    {
        return $this->currencyRepository->getByParams($params)->get();
    }
}
