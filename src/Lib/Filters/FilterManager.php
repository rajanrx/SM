<?php


namespace SM\Lib\Filters;

use SM\Lib\Filters\Interfaces\FilterTypeInterface;
use SM\Lib\Model\Interfaces\ModelInterface;

/**
 * Manages the filters and apply on Model Interface to filter them out
 * Class FilterManager
 * @package SM\Lib\Filters
 */
class FilterManager
{
    /**
     * @var FilterTypeInterface[]
     */
    private $filters = [];

    /**
     * Add filter
     * @param FilterTypeInterface $filter
     */
    public function addFilter(FilterTypeInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Add multiple filters
     * @param array $filters
     */
    public function addFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $this->addFilter($filter);
        }
    }

    /**
     * Returns model interfaces that satisfied defined filters
     * @param array $models
     * @return ModelInterface[]
     */
    public function applyFilter(array $models)
    {
        foreach ($models as $key => $model) {
            foreach ($this->filters as $filter) {
                // If any of the filter has failed then no need to check the
                // rest of them.
                if ($filter->process($model) === false) {
                    unset($models[$key]);
                    break;
                }
            }
        }

        // Reindex array to update array keys
        return array_values($models);
    }
}
