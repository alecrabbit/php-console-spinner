<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\Core\Probe\SignalHandlingProbe;
use AlecRabbit\Spinner\Core\Probe\StylingMethodProbe;
use AlecRabbit\Spinner\Exception\InvalidArgument;

use function AlecRabbit\Spinner\Root\getDefinitions;

// @codeCoverageIgnoreStart
require_once __DIR__ . '/Root/definitions.php';

Probes::register(
    SignalHandlingProbe::class,
    StylingMethodProbe::class,
);

$registry = DefinitionRegistry::getInstance();

/**
 * @var string|int $id
 * @var callable|object|class-string|IServiceDefinition $definition
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
            IServiceDefinition::TRANSIENT
        )
    );
}
// @codeCoverageIgnoreEnd
