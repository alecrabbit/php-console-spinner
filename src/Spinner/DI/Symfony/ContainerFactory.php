<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\DI\Symfony;

use AlecRabbit\Spinner\Container\Adapter\ContainerAdapter;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Container\Contract\IContainerFactory;
use AlecRabbit\Spinner\Container\Contract\IDefinitionRegistry;
use AlecRabbit\Spinner\Container\Contract\IReference;
use AlecRabbit\Spinner\Container\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference as SymfonyReference;

use function class_exists;
use function is_string;

final readonly class ContainerFactory implements IContainerFactory
{
    public function create(IDefinitionRegistry $registry): IContainer
    {
        $container = new ContainerBuilder();

        foreach ($registry->load() as $serviceDefinition) {
            $definition = $serviceDefinition->getDefinition();

            $service = null;

            if (is_string($definition) && class_exists($definition)) {
                $service = $container->autowire($serviceDefinition->getId(), $definition);
            }

            if ($definition instanceof IReference) {
                $service = $container->register($serviceDefinition->getId());
                $service->setFactory(new SymfonyReference((string)$definition));
            }

            if ($service && $serviceDefinition->isSingleton()) {
                $service->setShared(true);
            }

            if ($service && $serviceDefinition->isPublic()) {
                $service->setPublic(true);
            }
        }

        if (!$container->isCompiled()) {
            $container->compile();
        }

        return new ContainerAdapter($container);
    }

    public function isSupported(): bool
    {
        return class_exists(ContainerBuilder::class);
    }
}
