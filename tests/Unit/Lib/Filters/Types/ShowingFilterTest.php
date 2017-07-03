<?php
namespace SM\Unit\Lib\Filters\Types;

use DateTimeZone;
use SM\Lib\Filters\Types\ShowingFilter;

class ShowingFilterTest extends FilterTestHelper
{
    public function testShowingsFilterProcess()
    {
        $this->service->addFilter(
            (new ShowingFilter())->applyRules(
                [
                    ShowingFilter::FILTER_SHOWING_TIME_AHEAD => [
                        ShowingFilter::PARAM_NEXT_SHOW_IN_SECONDS => 30 *
                            60,
                        ShowingFilter::PARAM_INPUT_TIME           => date_create_from_format(
                            'H:i:sT',
                            '19:00:00+11:00',
                            new DateTimeZone('+11:00')
                        ),
                    ],
                ]
            )
        );
        $movies = $this->service->applyFilter($this->movies);

        $this->assertEquals(1, sizeof($movies));
        $this->assertEquals('Movie 2', $movies[0]->name);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid parameters provided
     */
    public function testThrowsExceptionIfInvalidParamsProvided()
    {
        $this->service->addFilter(
            (new ShowingFilter())->applyRules(
                [
                    ShowingFilter::FILTER_SHOWING_TIME_AHEAD => [
                        'foo' => 'yahoo',
                    ],
                ]
            )
        );
        $this->service->applyFilter($this->movies);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Next show second should be greater than zero
     */
    public function testThrowsExceptionIfInvalidNextShowInterval()
    {
        $this->service->addFilter(
            (new ShowingFilter())->applyRules(
                [
                    ShowingFilter::FILTER_SHOWING_TIME_AHEAD => [
                        ShowingFilter::PARAM_NEXT_SHOW_IN_SECONDS => '',
                        ShowingFilter::PARAM_INPUT_TIME           => date_create_from_format(
                            'H:i:sT',
                            '19:00:00+11:00',
                            new DateTimeZone('+11:00')
                        ),
                    ],
                ]
            )
        );
        $this->service->applyFilter($this->movies);
    }
}
