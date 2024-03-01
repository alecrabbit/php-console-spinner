<?php

declare(strict_types=1);

use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\ContainerBuilderFactory;
use AlecRabbit\Spinner\ContainerFactories;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Facade;

use function AlecRabbit\Spinner\Root\getDefinitions;

require_once __DIR__ . '/definitions.php';

// @codeCoverageIgnoreStart

// Register container factories
ContainerFactories::register(
    ContainerFactory::class,
);

// Register container builder factory
Facade::useFactoryClass(ContainerBuilderFactory::class);


$registry = DefinitionRegistry::getInstance();

// Bind definitions
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
        )
    );
}
// @codeCoverageIgnoreEnd
