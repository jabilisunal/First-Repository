<?php

namespace App\Repository;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;

class LanguageRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Language $model
     */
    public function __construct(Language $model)
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
            'short_name',
            'status',
        ];
    }
}
