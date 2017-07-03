<?php


namespace SM\Lib\Model;

use DateTime;
use DateTimeZone;
use SM\Models\Movie;

class MovieHelper
{
    /**
     * @param Movie $movie
     * @param DateTime $date
     * @param string $format
     * @return string
     */
    public static function getNearestShowingDate(
        Movie $movie,
        Datetime $date,
        string $format
    ) {
        foreach (self::getSortedShowings($movie) as $showing) {
            if ($date->getTimestamp() <= $showing->getTimestamp()) {
                return $showing->format($format);
            }
        }

        return '';
    }

    /**
     * @param Movie $movie
     * @return DateTime[]
     */
    protected static function getSortedShowings(Movie $movie)
    {
        /** @var DateTime[] $showings */
        $showings = [];
        foreach ($movie->showings as $showing) {
            $showings[] = date_create_from_format('H:i:sP', $showing, new DateTimeZone('+11:00'));
        }

        usort(
            $showings,
            function (DateTime $a, DateTime $b) {
                return $a->getTimestamp() < $b->getTimestamp() ? -1 : 1;
            }
        );

        return $showings;
    }
}
