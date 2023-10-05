<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\DefinitionRegistry;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/probes.php';
require_once __DIR__ . '/definitions.php';

$definitions = DefinitionRegistry::getInstance();

foreach (definitions() as $id => $definition) {
    $definitions->bind($id, $definition);
}
// @codeCoverageIgnoreEnd
