<?php

namespace SM\Models;

use DateTime;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;
use SM\Lib\Model\Interfaces\ModelInterface;

class Movie implements ModelInterface
{
    /**
     * @var string
     * @Type("string")
     * @SerializedName("name")
     */
    public $name;

    /**
     * @var integer
     * @Type("integer")
     * @SerializedName("rating")
     */
    public $rating;

    /**
     * @var string[]
     * @Type("array<string>")
     * @SerializedName("genres")
     */
    public $genres;

    /**
     * @var string[]
     * @Type("array<string>")
     * @SerializedName("showings")
     */
    public $showings;

    /**
     * @param DateTime $date
     * @param string   $format
     * @return string
     */
    public function getNearestShowingDate(Datetime $date, string $format)
    {
        foreach ($this->getSortedShowings() as $showing) {
            if ($date->getTimestamp() < $showing->getTimestamp()) {
                return $showing->format($format);
            }
        }
        return '';
    }

    /**
     * @return DateTime[]
     */
    protected function getSortedShowings()
    {
        /** @var DateTime[] $showings */
        $showings = [];
        foreach ($this->showings as $showing) {
            $showings[] = date_create_from_format('H:i:sP', $showing);
        }

        usort(
            $showings,
            function (DateTime $a, DateTime $b) {
                if ($a == $b) {
                    return 0;
                }

                return $a->getTimestamp() < $b->getTimestamp() ? -1 : 1;
            }
        );

        return $showings;
    }
}
