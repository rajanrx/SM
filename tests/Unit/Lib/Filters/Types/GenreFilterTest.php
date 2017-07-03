<?php
namespace SM\Unit\Lib\Filters\Types;

use SM\Lib\Filters\Types\GenreFilter;
use SM\Unit\Lib\Filters\FilterManagerTest;

class GenreFilterTest extends FilterManagerTest
{
    public function testFilterProcess()
    {
        $this->service->addFilter(
            (new GenreFilter())->applyRules(
                [
                    GenreFilter::FILTER_INPUT_GENRE => 'G2',
                ]
            )
        );
        $movies = $this->service->applyFilter($this->movies);

        $this->assertEquals(1, sizeof($movies));
        $this->assertEquals('Movie 1', $movies[0]->name);
    }
}
