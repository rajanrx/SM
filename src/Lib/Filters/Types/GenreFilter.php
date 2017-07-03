<?php

namespace SM\Lib\Filters\Types;

use SM\Lib\Filters\MovieFilter;
use SM\Lib\Filters\Interfaces\FilterTypeInterface;
use SM\Lib\Model\Interfaces\ModelInterface;
use SM\Models\Movie;

/**
 * Filter containing rules to filter out Genre
 * Class GenreFilter
 * @package SM\Lib\Filters\Types
 */
class GenreFilter extends MovieFilter implements FilterTypeInterface
{
    /**
     * Rule type to filter Genre based on their name
     */
    const FILTER_INPUT_GENRE = 'FILTER_INPUT_GENRE';

    /**
     * @param ModelInterface $model
     * @return bool
     */
    public function process(ModelInterface $model): bool
    {
        $this->checkModel($model);
        if (array_key_exists(self::FILTER_INPUT_GENRE, $this->rules) &&
            !$this->checkGenreExistsInMovie(
                $model,
                $this->rules[self::FILTER_INPUT_GENRE]
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Returns true if provided genre matches the available genre in Movie
     * @param ModelInterface $model
     * @param string         $genre
     * @return bool
     */
    protected function checkGenreExistsInMovie(
        ModelInterface $model,
        string $genre
    ) {
        if ($model instanceof Movie && in_array($genre, $model->genres)) {
            return true;
        }

        return false;
    }
}
