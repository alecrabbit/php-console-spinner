<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Core\Probe\ColorSupportProbe;
use AlecRabbit\Spinner\Core\Probe\SignalHandlingProbe;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/definitions.php';

Probes::register(
    SignalHandlingProbe::class,
    ColorSupportProbe::class,
);

$registry = DefinitionRegistry::getInstance();

/**
 * @var string $id
 * @var callable|object|string $definition
 */
foreach (getDefinitions() as $id => $definition) {
    $registry->bind($id, $definition);
}

$container = (new ContainerFactory($registry))->create();

Facade::useContainer($container);
// @codeCoverageIgnoreEnd
