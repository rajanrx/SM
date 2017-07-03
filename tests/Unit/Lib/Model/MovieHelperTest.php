<?php


namespace SM\Unit\Lib\Model;

use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use SM\Lib\Model\MovieHelper;
use SM\Models\Movie;

class MovieHelperTest extends TestCase
{
    public function testCanGetNearestShowingDate()
    {
        $movie = new Movie();
        $movie->showings = [
            '17:30:00+11:00',
            '18:30:00+11:00',
        ];
        $nearestShowingDate = MovieHelper::getNearestShowingDate(
            $movie,
            $this->getDate('17:00:00'),
            'h:i a'
        );
        $this->assertEquals('05:30 pm', $nearestShowingDate);

        $nearestShowingDate = MovieHelper::getNearestShowingDate(
            $movie,
            $this->getDate('17:31:00'),
            'h:i a'
        );
        $this->assertEquals('06:30 pm', $nearestShowingDate);

        $nearestShowingDate = MovieHelper::getNearestShowingDate(
            $movie,
            $this->getDate('18:31:00'),
            'h:i a'
        );
        $this->assertEquals('', $nearestShowingDate);
    }

    protected function getDate(string $time): DateTime
    {
        return date_create_from_format(
            'H:i:s',
            $time,
            new DateTimeZone('+11:00')
        );
    }
}
