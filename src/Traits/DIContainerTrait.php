<?php
namespace SM\Traits;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

trait DIContainerTrait
{
    /**
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        // Initiate dependency Injection
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../src/Config/')
        );
        $loader->load('Services.yml');

        return $container;
    }
}
