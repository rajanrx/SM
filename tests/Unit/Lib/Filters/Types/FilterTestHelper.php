<?php


namespace SM\Unit\Lib\Filters\Types;

use PHPUnit\Framework\TestCase;
use SM\Lib\Filters\FilterManager;
use SM\Models\Movie;
use SM\Traits\DIContainerTrait;

class FilterTestHelper extends TestCase
{
    use DIContainerTrait;

    /**
     * @var FilterManager
     */
    protected $service;

    /**
     * @var Movie[]
     */
    protected $movies;

    public function setUp()
    {
        parent::setUp();
        $container = $this->getContainer();
        $this->service = $container->get('sm.lib.filters.filter_manager');
        $this->setMovies();
    }


    protected function setMovies()
    {
        $this->movies = [
            $this->getMovie(
                [
                    'name'     => 'Movie 1',
                    'rating'   => 90,
                    'genres'   => [
                        'G1',
                        'G2',
                    ],
                    'showings' => [
                        '18:00:00+11:00',
                    ],
                ]
            ),
            $this->getMovie(
                [
                    'name'     => 'Movie 2',
                    'rating'   => 95,
                    'genres'   => [
                        'G1',
                        'G3',
                    ],
                    'showings' => [
                        '18:30:00+11:00',
                        '20:30:00+11:00',
                    ],
                ]
            ),
        ];
    }

    protected function getMovie(array $params)
    {
        $movie = new Movie();
        foreach ($params as $key => $value) {
            if (property_exists($movie, $key)) {
                $movie->$key = $value;
            }
        }

        return $movie;
    }
}
