<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractRepository
{
    /**
     * @var array $params
     */
    protected array $params = [];

    /**
     * AbstractRepository constructor
     *
     * @param Model $model
     */
    public function __construct(
        protected Model $model
    )
    {
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params): static
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return Model|null
     */
    public function findFirst(): ?Model
    {
        return $this->model::query()
            ->first();
    }

    /**
     * @param int $limit
     * @return Collection
     */
    public function findAll(int $limit = 15): Collection
    {
        return $this->buildQuery()
            ->limit($limit)
            ->get();
    }

    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 15): LengthAwarePaginator
    {
        return $this->buildQuery()
            ->paginate($limit);
    }

    /**
     * @param array $where
     * @return Model|null
     */
    public function findOneByCondition(array $where): ?Model
    {
        return $this->buildQuery()
            ->where($where)
            ->first();
    }

    /**
     * @param int|string $id
     * @return Model|null
     */
    public function find(int|string $id): ?Model
    {
        return $this->buildQuery()->findOrFail($id);
    }

    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        foreach ($params as $column => $value) {
            $this->model->$column = $value;
        }

        $this->model->save();

        return $this->model;
    }

    /**
     * @param array $params
     * @param int $id
     * @return Model
     */
    public function update(array $params, int $id): Model
    {
        $model = $this->find($id);
        $model->fill($params);
        $model->save();
        $model->fresh();

        return $model;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * @param string $id
     * @param string $value
     * @param $q
     * @return Collection
     */
    public function getOptions(string $id, string $value, $q): Collection
    {
        $query = $q ?? $this->buildQuery();

        return $query
            ->select($value, $id)
            ->orderBy($value)
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildQuery(): Builder
    {
        return $this->model::query();
    }
}
