<?php

namespace App\Repository;


use App\Models\Feature;

class FeatureRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Feature $model
     */
    public function __construct(Feature $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getByParams(array $params): mixed
    {
        return $this->buildQuery()
            ->select($this->selectedColumnsForList())
            ->when(isset($params['type']), function ($q) use ($params) {
                $q->type($params['type']);
            })
            ->when(isset($params['limit']), function ($q) use ($params) {
                $q->limit($params['limit']);
            })
            ->when(isset($params['sort_field'], $params['sort_value']), function ($q) use ($params) {
                $q->orderBy($params['sort_field'], $params['sort_value']);
            });
    }

    /**
     * @return string[]
     */
    public function selectedColumnsForList(): array
    {
        return [
            'id',
            'sort',
            'type',
            'color',
            'status'
        ];
    }
}
