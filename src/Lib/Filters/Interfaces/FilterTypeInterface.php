<?php

namespace SM\Lib\Filters\Interfaces;

use SM\Lib\Model\Interfaces\ModelInterface;

interface FilterTypeInterface
{
    public function applyRules(array $filters): FilterTypeInterface;

    public function process(ModelInterface $model): bool;
}
