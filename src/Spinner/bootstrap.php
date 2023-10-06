<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Facade;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/probes.php';
require_once __DIR__ . '/definitions.php';

$definitions = DefinitionRegistry::getInstance();

foreach (definitions() as $id => $definition) {
    $definitions->bind($id, $definition);
}

$container = (new ContainerFactory($definitions))->getContainer();

Facade::setContainer($container);
// @codeCoverageIgnoreEnd
