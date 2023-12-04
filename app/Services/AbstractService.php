<?php

namespace App\Services;

use App\Traits\ApiResponsible;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use App\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractService
{
    use ApiResponsible;

    /**
     * AbstractService constructor
     *
     * @param AbstractRepository $repository
     */
    public function __construct(
        protected AbstractRepository $repository
    ) {
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->repository->getModel();
    }

    /**
     * @param int $limit
     * @return Collection
     */
    public function findAll(int $limit = 15): Collection
    {
        return $this->repository->findAll($limit);
    }

    /**
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function pagination(int $limit = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($limit);
    }

    /**
     * @param null $query
     * @param string $value
     * @param string $id
     * @return Collection
     */
    public function getOptions($query = null, string $value = 'name', string $id = 'id'): Collection
    {
        return $this->repository->getOptions($id, $value, $query);
    }

    /**
     * @param array $params
     * @return Model
     */
    public function save(array $params): Model
    {
        return $this->repository->save($params);
    }

    /**
     * @param array $params
     * @param int $id
     * @return Model
     */
    public function update(array $params, int $id): Model
    {
        return $this->repository->update($params, $id);
    }

    /**
     * @return ?Model
     */
    public function findFirst(): ?Model
    {
        return $this->repository->findFirst();
    }

    /**
     * @param int $id
     * @return ?Model
     */
    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $where
     * @return ?Model
     */
    public function findOneByCondition(array $where): ?Model
    {
        return $this->repository->findOneByCondition($where);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function findAndDelete(int $id): JsonResponse
    {
        $this->repository->find($id);

        return $this->delete($id);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->repository->delete($id);

        return $this->successResponse(Response::HTTP_OK);
    }
}
