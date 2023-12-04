<?php

namespace App\Repository;

use App\Models\Page;

class PageRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getOneByParams(array $params): mixed
    {
        return $this->buildQuery()
            ->select($this->selectedColumnsForList())
            ->when(isset($params['slug']), function ($q) use ($params) {
                $q->slug($params['slug']);
            });
    }

    /**
     * @return string[]
     */
    public function selectedColumnsForList(): array
    {
        return [
            'id',
            'slug',
            'sort',
            'status',
        ];
    }
}
