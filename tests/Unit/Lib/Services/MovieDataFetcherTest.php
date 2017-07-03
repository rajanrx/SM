<?php


namespace SM\Unit\Lib\Services;

use PHPUnit\Framework\TestCase;
use SM\Lib\Services\MovieDataFetcher;
use SM\Traits\DIContainerTrait;

class MovieDataFetcherTest extends TestCase
{
    use DIContainerTrait;

    public function testServiceCanBeLoaded()
    {
        $container = $this->getContainer();
        $movieFetcherService =
            $container->get('sm.lib.services.movie_data_fetcher');
        $this->assertInstanceOf(MovieDataFetcher::class, $movieFetcherService);
    }
}
