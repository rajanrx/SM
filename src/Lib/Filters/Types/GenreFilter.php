<?php

namespace SM\Lib\Filters\Types;

use SM\Lib\Filters\MovieFilter;
use SM\Lib\Filters\Interfaces\FilterTypeInterface;
use SM\Lib\Model\Interfaces\ModelInterface;
use SM\Models\Movie;

class GenreFilter extends MovieFilter implements FilterTypeInterface
{
    const FILTER_INPUT_GENRE = 'FILTER_INPUT_GENRE';

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