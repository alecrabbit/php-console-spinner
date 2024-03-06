<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\DI\PhpDI;

use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Reference;
use DI;

use function class_exists;
use function is_string;

final readonly class ContainerFactory implements IContainerFactory
{
    public function create(IDefinitionRegistry $registry): IContainer
    {
        $builder = new DI\ContainerBuilder();

        foreach ($registry->load() as $serviceDefinition) {
            $definition = $serviceDefinition->getDefinition();

            if (is_string($definition) && class_exists($definition)) {
                $builder->addDefinitions([$serviceDefinition->getId() => DI\autowire($definition)]);
            }

            if ($definition instanceof Reference) {
                $builder->addDefinitions([$serviceDefinition->getId() => DI\factory((string)$definition)]);
            }
        }

        return new ContainerAdapter($builder->build());
    }

    public function isSupported(): bool
    {
        return class_exists(DI\ContainerBuilder::class);
    }
}
