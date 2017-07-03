<?php
namespace SM\Unit\Lib\Filters\Types;

use SM\Lib\Filters\Types\ShowingFilter;
use SM\Unit\Lib\Filters\FilterManagerTest;

class ShowingFilterTest extends FilterManagerTest
{
    public function testFilterProcess()
    {
        $this->service->addFilter(
            (new ShowingFilter())->applyRules(
                [
                    ShowingFilter::FILTER_SHOWING_TIME_AHEAD => [
                        ShowingFilter::PARAM_NEXT_SHOW_IN_SECONDS => 30 *
                            60,
                        ShowingFilter::PARAM_INPUT_TIME           => date_create_from_format(
                            'H:i:sT',
                            '17:00:00+11:00'
                        ),
                    ],
                ]
            )
        );
        $movies = $this->service->applyFilter($this->movies);

        $this->assertEquals(2, sizeof($movies));
        $this->assertEquals('Movie 1', $movies[0]->name);
    }
}
