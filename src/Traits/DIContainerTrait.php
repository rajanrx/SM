<?php
namespace SM\Traits;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * This trait can be used for loading the configuration based on the
 * config files stored in Config directory.
 * Trait DIContainerTrait
 * @package SM\Traits
 */
trait DIContainerTrait
{
    /**
     * Get DI services and configured parameters
     * @return ContainerBuilder
     */
    public static function getContainer(): ContainerBuilder
    {
        // Initiate dependency Injection
        $container = new ContainerBuilder();
        // State configuration directory for YAML configuration files
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../src/Config/')
        );
        // Load service configurations
        $loader->load('Services.yml');

        return $container;
    }
}
