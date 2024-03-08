<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root;

use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\DI\ContainerBuilderFactory;
use AlecRabbit\Spinner\DI\ContainerFactories;
use AlecRabbit\Spinner\DI\PhpDI\PHPDIContainerFactory;
use AlecRabbit\Spinner\DI\Symfony\SymfonyContainerFactory;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/registry.php';

// Register container factories
ContainerFactories::register(
    ContainerFactory::class,
    PHPDIContainerFactory::class,
    SymfonyContainerFactory::class,
);

// Set container builder factory
Facade::useFactoryClass(ContainerBuilderFactory::class);
// @codeCoverageIgnoreEnd
