<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Facade;
use AlecRabbit\Tests\Helper\BenchmarkingDriverBuilder;

require_once __DIR__ . '/../../bootstrap.php';

// Replace default container with custom one:
{
    $registry = DefinitionRegistry::getInstance();

    $registry->bind(IDriverBuilder::class, BenchmarkingDriverBuilder::class);

    $container = (new ContainerFactory($registry))->getContainer();

    Facade::setContainer($container);
}

$spinner = Facade::createSpinner();
$driver = Facade::getDriver();

// perform example unrelated actions:
require_once __DIR__ . '/../bootstrap.async.php';
