<?php
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once __DIR__ . '/../vendor/autoload.php';
date_default_timezone_set('UTC');

// Unfortunately the annotation reader is not automatically registered on composer
// So we need to add it manually.
AnnotationRegistry::registerLoader('class_exists');
