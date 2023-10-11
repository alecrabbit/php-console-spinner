<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Probe\ColorSupportProbe;
use AlecRabbit\Spinner\Core\Probe\SignalProcessingProbe;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/definitions.php';

Probes::register(
    SignalProcessingProbe::class,
    ColorSupportProbe::class,
);

$registry = DefinitionRegistry::getInstance();

foreach (getDefinitions() as $id => $definition) {
    $registry->bind($id, $definition);
}

$container = (new ContainerFactory($registry))->getContainer();

Facade::setContainer($container);
// @codeCoverageIgnoreEnd
