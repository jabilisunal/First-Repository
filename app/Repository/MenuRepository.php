<?php

namespace App\Repository;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;

class MenuRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param \App\Models\Menu $model
     */
    public function __construct(Menu $model)
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
            ->when(isset($params['menu_type_id']), function ($q) use ($params) {
                $q->menuType($params['menu_type_id']);
            });
    }

    /**
     * @return string[]
     */
    public function selectedColumnsForList(): array
    {
        return [
            'id',
            'menu_type_id',
            'parent_id',
            'slug',
            'sort',
            'status',
            'style',
            'target_blank',
            'is_new'
        ];
    }
}
