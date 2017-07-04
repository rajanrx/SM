<?php

namespace SM\Lib\Config;

use Symfony\Component\Yaml\Yaml;

/**
 * This class manages configured parameters
 * Class Config
 * @package SM\Lib\Config
 */
class Config
{
    /** @var  array */
    protected static $config;

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        if (self::$config === null) {
            // Get all the configured parameters from YAML file
            self::$config = Yaml::parse(
                file_get_contents(__DIR__ . '/../../../src/Config/Config.yml')
            );
            return self::$config;
        }

        return self::$config;
    }

    /**
     * Returns specific config param if key path is defined
     * Otherwise returns all defined configuration
     * @param null $keyPath path in dotted notation
     * @return mixed
     */
    public static function get($keyPath = null)
    {
        $config = self::getConfig();
        if (is_null($keyPath)) {
            return $config;
        }

        $pieces = explode('.', $keyPath);

        return self::getNestedVar($config, $pieces);
    }

    /**
     * Finds the value for key represented in dotted notation
     * @param array $content
     * @param array $pieces
     * @return mixed
     * @throws \Exception
     * @SuppressWarnings
     */
    protected static function getNestedVar(array $content, array $pieces)
    {
        if (!isset($pieces[0]) || !array_key_exists($pieces[0], $content)) {
            throw new \Exception(
                'Param does not exists '
            );
        }
        $firstElement = $pieces[0];
        // Recursively get array elements until last key
        while (count($pieces) > 1) {
            unset($pieces[0]);

            return self::getNestedVar(
                $content[$firstElement],
                array_values($pieces)
            );
        }

        return $content[$firstElement];
    }
}
