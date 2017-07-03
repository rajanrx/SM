<?php

namespace SM\Lib\Filters;

use SM\Lib\Filters\Interfaces\FilterTypeInterface;
use SM\Lib\Model\Interfaces\ModelInterface;
use SM\Models\Movie;

abstract class MovieFilter implements FilterTypeInterface
{
    /**
     * @var array
     */
    public $rules;

    public function applyRules(array $rules): FilterTypeInterface
    {
        foreach ($rules as $ruleName => $data) {
            if (!defined("static::$ruleName")) {
                throw new \Exception(
                    "{$ruleName} does not exists for " . get_class($this)
                );
            }
        }
        $this->rules = $rules;
        return $this;
    }

    protected function checkModel(ModelInterface $model)
    {
        if (!$model instanceof Movie) {
            throw new \Exception(
                'Genre filter can only be applied for Movie.'
            );
        }
    }
}
