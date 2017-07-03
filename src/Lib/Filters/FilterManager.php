<?php


namespace SM\Lib\Filters;

use SM\Lib\Filters\Interfaces\FilterTypeInterface;
use SM\Lib\Model\Interfaces\ModelInterface;

class FilterManager
{
    /**
     * @var FilterTypeInterface[]
     */
    private $filters = [];

    /**
     * @param FilterTypeInterface $filter
     */
    public function addFilter(FilterTypeInterface $filter)
    {
        $this->filters[] = $filter;
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * @param array $models
     * @return ModelInterface[]
     */
    public function applyFilter(array $models)
    {
        foreach ($models as $key => $model) {
            foreach ($this->filters as $filter) {
                if ($filter->process($model) === false) {
                    unset($models[$key]);
                    break;
                }
            }
        }

        // Reindex array
        return array_values($models);
    }
}
