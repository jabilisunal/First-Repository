<?php

namespace App\Repository;

use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;

class BannerRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Banner $model
     */
    public function __construct(Banner $model)
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
            ->when(isset($params['banner_type_id']), function ($q) use ($params) {
                $q->bannerType($params['banner_type_id']);
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
            'type_id',
            'position',
            'sort',
            'status',
            'effect',
            'duration'
        ];
    }
}
