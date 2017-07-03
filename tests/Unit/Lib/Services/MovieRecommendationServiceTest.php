<?php

use SM\Lib\Services\MovieDataFetcher;
use SM\Lib\Services\MovieRecommendationService;
use SM\Traits\DIContainerTrait;

class MovieRecommendationServiceTest extends \PHPUnit\Framework\TestCase
{
    use DIContainerTrait;

    /** @var  MovieRecommendationService */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $mockMovieDataFetcher =
            $this->getMockBuilder(MovieDataFetcher::class)
                ->disableOriginalConstructor()
                ->getMock();
        $mockMovieDataFetcher->expects($this->any())
            ->method('getMovieData')
            ->will($this->returnValue($this->getJSON()));
        $container->set(
            'sm.lib.services.movie_data_fetcher',
            $mockMovieDataFetcher
        );

        $this->service =
            $container->get('sm.lib.services.movie_recommendation_service');
    }

    public function testCanLoadService()
    {
        $this->assertInstanceOf(
            MovieRecommendationService::class,
            $this->service
        );
    }

    /**
     * @depends testCanLoadService
     */
    public function testCanGetRecommendMovieAndAreSorted()
    {
        $movies = $this->service->getRecommendedMovie(
            'Comedy',
            date_create_from_format(
                'H:i:sT',
                '18:29:00+11:00'
            )
        );
        $this->assertEquals(2, sizeof($movies));

        // Assert movies are sorted based on their ratings
        $this->assertEquals('Zootopia', $movies[0]->name);
        $this->assertEquals('Shaun The Sheep', $movies[1]->name);
    }

    public function getJSON()
    {
        return file_get_contents(__DIR__ . '/../../../data/movies.json');
    }
}