<?php

namespace SM\Lib\Config;

use Symfony\Component\Yaml\Yaml;

class Config
{
    /** @var  array */
    protected static $config;

    protected static function getConfig()
    {
        if (self::$config === null) {
            return Yaml::parse(
                file_get_contents(__DIR__ . '/../../../src/Config/Config.yml')
            );
        }

        return self::$config;
    }

    public static function get($keyPath = null)
    {
        $config = self::getConfig();
        if (is_null($keyPath)) {
            return $config;
        }

        $pieces = explode('.', $keyPath);
        return self::getNestedVar($config, $pieces);
    }

    protected static function getNestedVar(array $array, array $pieces)
    {
        if (!array_key_exists($pieces[0], $array)) {
            throw new \Exception(
                'Param does not exists ' . implode('.', $pieces)
            );
        }
        $firstElement = $pieces[0];
        while (sizeof($pieces) > 1) {
            unset($pieces[0]);

            return self::getNestedVar(
                $array[$firstElement],
                array_values($pieces)
            );
        }

        return $array[$firstElement];
    }
}