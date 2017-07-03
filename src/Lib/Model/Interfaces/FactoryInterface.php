<?php

namespace SM\Lib\Model\Interfaces;

interface FactoryInterface
{

    /**
     * @param string $json
     * @param ModelInterface $modelInstance
     * @return ModelInterface
     */
    public function fromJSON(string $json, ModelInterface $modelInstance);

    /**
     * @param string $json
     * @param ModelInterface $modelInstance
     * @return ModelInterface[]
     */
    public function arrayFromJSON(
        string $json,
        ModelInterface $modelInstance
    );
}
