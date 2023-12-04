<?php

namespace App\Repository;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Builder;

class CurrencyRepository extends AbstractRepository {

    /**
     * BlacklistRepository constructor
     *
     * @param Currency $model
     */
    public function __construct(Currency $model)
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
            ->when(isset($params['status']), function ($q) use ($params) {
                $q->status($params['status']);
            });
    }

    /**
     * @return string[]
     */
    public function selectedColumnsForList(): array
    {
        return [
            'id',
            'name',
            'code',
            'symbol',
            'status',
        ];
    }
}
