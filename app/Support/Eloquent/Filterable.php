<?php

namespace App\Support\Eloquent;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder as Filter;

trait Filterable
{
    /**
     * @var array|array[] $filters
     */
    private static array $filters = [
        'includes' => [],
        'fields'   => [],
        'sorts'    => [],
        'filters'  => []
    ];

    /**
     * @param array $filters
     * @param Request|null $request
     * @param null $builder
     * @return Filter
     */
    public function asFilter(array $filters = [], Request $request = null, $builder = null): Filter
    {
        return $this->filterBuilderChainMethods($this->getFilter($request,$builder), $filters);
    }

    /**
     * @param Filter $filter
     * @param array $filters
     * @return Filter
     */
    private function filterBuilderChainMethods(Filter $filter, array $filters = []): Filter
    {
        $filters = array_merge($this->getFilters(), $filters);

        return $filter->allowedFields($filters['fields'] ?? [])
            ->allowedIncludes($filters['includes'] ?? [])
            ->allowedFilters($filters['filters'] ?? [])
            ->allowedSorts($filters['sorts'] ?? []);
    }

    /**
     * @param null $request
     * @param null $builder
     * @return Filter
     */
    public function getFilter($request = null, $builder = null): Filter
    {
        return Filter::for($builder ?? $this, $this->createRequestForFilters($request));
    }

    /**
     * @param null $request
     * @return mixed
     */
    protected function createRequestForFilters($request = null): mixed
    {
        $request = $request ?? app(Request::class);

        return $this->requestFilterValueCasting($request);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function requestFilterValueCasting($request): mixed
    {
        if (property_exists($this, 'query_filter_casts')) {

            $values = $request->query->get('filter', []);

            foreach ($this->query_filter_casts as $key => $cast) {
                if (!empty($values[$key]) && !strpos($values[$key], ',')) {
                    $values[$key] = cast($values[$key], $cast);
                }
            }
            $request->query->set('filter', $values);
        }

        return $request;
    }

    /**
     * @param $builder
     * @param array $filters
     * @return Filter
     */
    public function scopeFilter($builder, array $filters = []): Filter
    {
        return $this->filterBuilderChainMethods($this->getFilter(null, $builder), $filters);
    }

    /**
     * @param $request
     * @return array
     */
    public function getPassedIncludes($request): array
    {
        return array_intersect(
            explode(',',$request->get('include', '')),
            $this->getFilters()['includes'] ?? [],
        );
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return self::$filters;
    }

}
