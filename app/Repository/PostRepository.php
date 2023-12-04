<?php

namespace App\Repository;


use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostRepository extends AbstractRepository
{

    /**
     * BlacklistRepository constructor
     *
     * @param Post $model
     */
    public function __construct(Post $model)
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
            ->when(isset($params['limit']), function ($q) use ($params) {
                $q->limit($params['limit']);
            })
            ->when(isset($params['sort_field'], $params['sort_value']), function ($q) use ($params) {
                $q->orderBy($params['sort_field'], $params['sort_value']);
            });
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
            'sort',
            'status',
            'slug',
        ];
    }
}
