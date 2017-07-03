<?php


namespace SM\Lib\Services;

use DateTime;
use SM\Lib\Filters\FilterManager;
use SM\Lib\Filters\Types\GenreFilter;
use SM\Lib\Filters\Types\ShowingFilter;
use SM\Lib\Model\ModelFactory;
use SM\Models\Movie;

/**
 * Gets recommended movie using set of defined filters
 * Class MovieRecommendationService
 * @package SM\Lib\Services
 */
class MovieRecommendationService
{
    /**
     * @var MovieDataFetcher
     */
    private $movieDataFetcher;

    /**
     * @var ModelFactory
     */
    private $modelFactory;

    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @var integer
     */
    protected $nextShowInSeconds;

    /**
     * MovieRecommendationService constructor.
     * @param ModelFactory     $modelFactory
     * @param FilterManager    $filterManager
     * @param MovieDataFetcher $movieDataFetcher
     */
    public function __construct(
        ModelFactory $modelFactory,
        FilterManager $filterManager,
        MovieDataFetcher $movieDataFetcher
    ) {
        $this->modelFactory = $modelFactory;
        $this->filterManager = $filterManager;
        $this->movieDataFetcher = $movieDataFetcher;
    }

    /**
     * @param int $nextShowInSeconds
     */
    public function setNextShowInSeconds(int $nextShowInSeconds)
    {
        $this->nextShowInSeconds = $nextShowInSeconds;
    }

    /**
     * Gets array of recommended movies using defined filters
     * @param string   $genre
     * @param DateTime $time
     * @return Movie[]
     */
    public function getRecommendedMovie(string $genre, DateTime $time): array
    {
        $moviesJson = $this->movieDataFetcher->getMovieData();
        $movies = $this->modelFactory->arrayFromJSON($moviesJson, new Movie());
        $this->addFilters($genre, $time);
        $movies = $this->filterManager->applyFilter($movies);

        // If the size of movies are greater than one then sort them based
        // on their ratings
        if (count($movies) > 1) {
            usort(
                $movies,
                function (Movie $a, Movie $b) {
                    return $a->rating < $b->rating;
                }
            );
        }

        return $movies;
    }

    /**
     * Add filters based on the provided params
     * @param string   $genre
     * @param DateTime $time
     */
    protected function addFilters(string $genre, DateTime $time)
    {
        $this->filterManager->addFilters(
            [
                (new GenreFilter())->applyRules(
                    [
                        GenreFilter::FILTER_INPUT_GENRE => $genre,
                    ]
                ),
                (new ShowingFilter())->applyRules(
                    [
                        ShowingFilter::FILTER_SHOWING_TIME_AHEAD => [
                            ShowingFilter::PARAM_NEXT_SHOW_IN_SECONDS => $this->nextShowInSeconds,
                            ShowingFilter::PARAM_INPUT_TIME           => $time,
                        ],
                    ]
                ),
            ]
        );
    }
}
