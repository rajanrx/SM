<?php

namespace SM\Unit\Lib\Filters\Types;

use SM\Lib\Filters\Types\GenreFilter;
use SM\Unit\Lib\Model\FakeModel;

class GenreFilterTest extends FilterTestHelper
{
    public function setUp()
    {
        parent::setUp();
        $this->service->addFilter(
            (new GenreFilter())->applyRules(
                [
                    GenreFilter::FILTER_INPUT_GENRE => 'G2',
                ]
            )
        );
    }

    public function testGenreFilterProcess()
    {
        $movies = $this->service->applyFilter($this->movies);
        $this->assertEquals(1, sizeof($movies));
        $this->assertEquals('Movie 1', $movies[0]->name);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage SM\Lib\Filters\Types\GenreFilter filter can
     *     only be applied for Movie
     */
    public function testThrowsExceptionIfNotAppliedOnMovieInstance()
    {
        $this->service->applyFilter([new FakeModel()]);
    }
}
