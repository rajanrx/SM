<?php

namespace SM\Unit\Lib\Model;

use PHPUnit\Framework\TestCase;
use SM\Lib\Model\ModelFactory;
use SM\Models\Movie;
use SM\Traits\DIContainerTrait;

class ModelFactoryTest extends TestCase
{
    use DIContainerTrait;

    /**
     * @var string
     */
    protected $jsonData;

    /**
     * @var ModelFactory
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->jsonData =
            file_get_contents(__DIR__ . '/../../../data/movies.json');
        $container = $this->getContainer();
        $this->service = $container->get('sm.lib.model_factory');
    }

    public function testCanLoadService()
    {
        $this->assertInstanceOf(ModelFactory::class, $this->service);
    }

    public function testCanLoadModels()
    {
        /** @var Movie[] $movies */
        $movies = $this->service->arrayFromJSON(
            $this->jsonData,
            new Movie()
        );
        $this->assertEquals(4, sizeof($movies));
        $this->assertInstanceOf(Movie::class, $movies[0]);
        $this->assertEquals('Moonlight', ($movies[0])->name);
        $this->assertEquals(98, ($movies[0])->rating);
        $this->assertEquals(['Drama'], ($movies[0])->genres);
        $this->assertEquals(
            ['18:30:00+11:00', '20:30:00+11:00'],
            ($movies[0])->showings
        );
    }

    public function testCanLoadModel()
    {
        $sampleData = [
            'name' => 'foo',
            'rating' => 20,
            'showings' => [
                '18:30:00+11:00'
            ],
            'genres' => [
                'lol'
            ]
        ];

        /** @var Movie $movie */
        $movie = $this->service->fromJSON(
            json_encode($sampleData),
            new Movie()
        );

        $this->assertNotNull($movie);
        $this->assertInstanceOf(Movie::class, $movie);
        $this->assertEquals('foo', $movie->name);
    }
}
