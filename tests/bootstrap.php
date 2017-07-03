<?php
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/../vendor/autoload.php';
// Unfortunately the annotation reader is not automatically registered on composer
// So we need to add it manually.
AnnotationRegistry::registerLoader('class_exists');
