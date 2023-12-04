<?php

namespace App\Services;

use App\Repository\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService extends AbstractService
{
    /**
     * @param \App\Repository\PostRepository $postRepository
     */
    public function __construct(
        public PostRepository $postRepository,
    ) {
        parent::__construct($postRepository);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getListsByParams(array $params): mixed
    {
        return $this->postRepository->getByParams($params);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function getOneByParams(array $params): mixed
    {
        return $this->postRepository->getOneByParams($params);
    }
}
