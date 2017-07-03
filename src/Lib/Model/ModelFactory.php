<?php

namespace SM\Lib\Model;

use JMS\Serializer\SerializerBuilder;
use SM\Lib\Model\Interfaces\FactoryInterface;
use SM\Lib\Model\Interfaces\ModelInterface;

class ModelFactory implements FactoryInterface
{
    /**
     * @param string         $json
     * @param ModelInterface $modelInstance
     * @return ModelInterface
     */
    public function fromJSON(string $json, ModelInterface $modelInstance)
    {
        $type = get_class($modelInstance);

        return $this->deserializeModel($json, $type);
    }

    /**
     * @param string         $json
     * @param ModelInterface $modelInstance
     * @return ModelInterface[]
     */
    public function arrayFromJSON(
        string $json,
        ModelInterface $modelInstance
    ) {
        $type = 'array<' . get_class($modelInstance) . '>';

        return $this->deserializeModel($json, $type);
    }

    /**
     * @param string         $json
     * @param string         $type
     * @return ModelInterface | ModelInterface[]
     */
    protected function deserializeModel(
        string $json,
        string $type
    ) {
        $serializer = SerializerBuilder::create()->build();

        return $serializer->deserialize($json, $type, 'json');
    }
}
