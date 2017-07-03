<?php

namespace SM\Unit\Lib\Filters;

use SM\Lib\Filters\FilterManager;
use SM\Lib\Filters\Types\ShowingFilter;
use SM\Unit\Lib\Filters\Types\FilterTestHelper;

class FilterManagerTest extends FilterTestHelper
{
    public function testFilterManagerServiceIsLoaded()
    {
        $this->assertInstanceOf(
            FilterManager::class,
            $this->service
        );
    }

    public function testFillWillReturnAllModelsIfNoFiltersAreApplied()
    {
        $container = $this->getContainer();
        $this->service = $container->get('sm.lib.filters.filter_manager');
        $movies = $this->service->applyFilter($this->movies);
        $this->assertEquals(2, sizeof($movies));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage invalidRule does not exists for
     *     SM\Lib\Filters\Types\ShowingFilter
     */
    public function testInvalidFilterConfigurationWillThrowException()
    {
        $this->service->addFilter(
            (new ShowingFilter())->applyRules(
                [
                    'invalidRule' => [],
                ]
            )
        );
    }
}
