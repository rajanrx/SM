<?php

namespace SM\Models;

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
}
