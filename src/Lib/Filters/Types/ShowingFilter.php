<?php


namespace SM\Lib\Filters\Types;

use DateTime;
use DateTimeZone;
use SM\Lib\Filters\Interfaces\FilterTypeInterface;
use SM\Lib\Filters\MovieFilter;
use SM\Lib\Model\Interfaces\ModelInterface;
use SM\Models\Movie;

/**
 * Class ShowingFilter
 * @package SM\Lib\Filters\Types
 */
class ShowingFilter extends MovieFilter implements FilterTypeInterface
{
    /**
     * Rules to only show movies that ahead of provided time
     */
    const FILTER_SHOWING_TIME_AHEAD = 'FILTER_SHOWING_TIME_AHEAD';

    /**
     * Number of second to consider for rule FILTER_SHOWING_TIME_AHEAD
     */
    const PARAM_NEXT_SHOW_IN_SECONDS = 'nextShowInSeconds';

    /**
     * Input time for rule FILTER_SHOWING_TIME_AHEAD
     */
    const PARAM_INPUT_TIME = 'inputTime';

    /**
     * @param ModelInterface $model
     * @return bool
     */
    public function process(ModelInterface $model): bool
    {
        if (array_key_exists(self::FILTER_SHOWING_TIME_AHEAD, $this->rules) &&
            !$this->isMovieInNextTimeAhead(
                $model,
                $this->rules[self::FILTER_SHOWING_TIME_AHEAD]
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Returns true if show time is ahead of provided input time by defined
     * next show difference
     * @param ModelInterface $model
     * @param array          $params
     * @return bool
     * @throws \Exception
     */
    protected function isMovieInNextTimeAhead(
        ModelInterface $model,
        array $params
    ): bool {

        // Check if the provided params are correct
        if (!array_key_exists(self::PARAM_NEXT_SHOW_IN_SECONDS, $params) ||
            !array_key_exists(self::PARAM_INPUT_TIME, $params) ||
            !$params[self::PARAM_INPUT_TIME] instanceof DateTime
        ) {
            throw new \Exception('Invalid parameters provided');
        }

        $inputTime = $params[self::PARAM_INPUT_TIME];
        $nextShowInSeconds = (integer)$params[self::PARAM_NEXT_SHOW_IN_SECONDS];

        if ($nextShowInSeconds <= 0) {
            throw new \Exception(
                "Next show second should be greater than zero"
            );
        }

        if ($model instanceof Movie && count($model->showings)) {
            foreach ($model->showings as $showing) {
                $date = date_create_from_format('H:i:sP', $showing, new DateTimeZone('+11:00'));
                $diffInSeconds =
                    $date->getTimestamp() - $inputTime->getTimestamp();
                if ($diffInSeconds >= $nextShowInSeconds) {
                    return true;
                }
            }
        }

        return false;
    }
}
