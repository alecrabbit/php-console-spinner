<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root;

use AlecRabbit\Spinner\Container\Contract\IReference;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Exception\InvalidArgument;

// @codeCoverageIgnoreStart

require_once __DIR__ . '/definitions.php';

$registry = DefinitionRegistry::getInstance();

// Bind definitions
/**
 * @var string|int $id
 * @var class-string|IReference|IServiceDefinition $definition
 */
foreach (getDefinitions() as $id => $definition) {
    if ($definition instanceof IServiceDefinition) {
        $registry->bind($definition);
        continue;
    }

    if (!is_string($id)) {
        throw new InvalidArgument(
            sprintf(
                'Id must be a string, "%s" given.',
                get_debug_type($id)
            )
        );
    }

    $registry->bind(
        new ServiceDefinition(
            $id,
            $definition,
        )
    );
}
// @codeCoverageIgnoreEnd
