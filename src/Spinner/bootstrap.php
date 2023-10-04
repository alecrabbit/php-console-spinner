<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Core\Probe\SignalProcessingProbe;
use AlecRabbit\Spinner\Probes;

require_once __DIR__ . '/definitions.php';

// @codeCoverageIgnoreStart
Probes::register(
    SignalProcessingProbe::class,
);

$definitions = DefinitionRegistry::getInstance();

foreach (definitions() as $id => $definition) {
    $definitions->bind($id, $definition);
}
// @codeCoverageIgnoreEnd
