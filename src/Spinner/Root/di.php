<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root;

use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\DI\ContainerBuilderFactory;
use AlecRabbit\Spinner\DI\ContainerFactories;
use AlecRabbit\Spinner\DI\PhpDI\ContainerFactory as PHPDIContainerFactory;
use AlecRabbit\Spinner\DI\Symfony\ContainerFactory as SymfonyContainerFactory;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/registry.php';

// Register container factories
ContainerFactories::register(
    ContainerFactory::class,
    SymfonyContainerFactory::class,
    PHPDIContainerFactory::class,
);

// Set container builder factory
Facade::useFactoryClass(ContainerBuilderFactory::class);
// @codeCoverageIgnoreEnd
