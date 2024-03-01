<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Root;

use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\DefinitionRegistry;
use AlecRabbit\Spinner\Container\Factory\ContainerFactory;
use AlecRabbit\Spinner\Container\ServiceDefinition;
use AlecRabbit\Spinner\DI\ContainerBuilderFactory;
use AlecRabbit\Spinner\DI\ContainerFactories;
use AlecRabbit\Spinner\DI\Symfony\ContainerFactory as SymfonyContainerFactory;
use AlecRabbit\Spinner\DI\PhpDI\ContainerFactory as PHPDIContainerFactory;
use AlecRabbit\Spinner\Exception\InvalidArgument;
use AlecRabbit\Spinner\Facade;

require_once __DIR__ . '/definitions.php';

// @codeCoverageIgnoreStart

// Register container factories
ContainerFactories::register(
    ContainerFactory::class,
    SymfonyContainerFactory::class,
    PHPDIContainerFactory::class,
);

// Set container builder factory
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
