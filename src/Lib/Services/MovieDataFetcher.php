<?php


namespace SM\Lib\Services;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;

class MovieDataFetcher
{
    /**
     * @var string
     */
    private $movieUrl;

    function __construct(string $movieUrl)
    {
        $this->movieUrl = $movieUrl;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getMovieData()
    {

        if (empty($this->movieUrl)) {
            throw new \Exception('Movie Url cannot be empty');
        }
        // Create default HandlerStack for Guzzle client caching
        $stack = HandlerStack::create();

        // We can use greedy caching strategy that allows defining an expiry TTL
        // disregarding any possibly present caching headers if we need to force
        // cache TTL

        // $stack->push(
        // new CacheMiddleware(
        //    new GreedyCacheStrategy(
        //        new DoctrineCacheStorage(
        //            new FilesystemCache('/tmp/')
        //        ),
        //        1800 // the TTL in seconds
        //    )
        // ),
        //  'greedy-cache'
        // );
        $stack->push(new CacheMiddleware(), 'cache');

        // Initialize the client with the handler option
        $client = new Client(['handler' => $stack]);
        $response = $client->get($this->movieUrl);
        if (!in_array($response->getStatusCode(), [200, 202, 203, 204])) {
            throw new \Exception('Could not get Movie Data');
        }
        $moviesJson = $response->getBody()->getContents();

        return $moviesJson;
    }
}