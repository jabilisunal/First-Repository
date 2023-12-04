<?php

namespace App\Repository;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Category $model
     */
    public function __construct(Category $model)
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
            ->with(['products'])
            ->when(isset($params['parent_id']), function ($q) use ($params) {
                $parent_id = (int)$params['parent_id'] === 0 ? null : (int)$params['parent_id'];
                $q->parent($parent_id);
            })
            ->select($this->selectedColumnsForList());
    }

    /**
     * @return string[]
     */
    public function selectedColumnsForList(): array
    {
        return [
            'id',
            'parent_id',
            'slug',
            'color',
            'sort',
            'status',
        ];
    }
}
