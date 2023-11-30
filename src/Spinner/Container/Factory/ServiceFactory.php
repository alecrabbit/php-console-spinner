<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Builder\ServiceBuilder;
use AlecRabbit\Spinner\Container\Contract\IIsStorableResolver;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceBuilder;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\IServiceFactory;
use AlecRabbit\Spinner\Container\ServiceIsStorableResolver;

final readonly class ServiceFactory implements IServiceFactory
{
    public function __construct(
        private IIsStorableResolver $isStorableResolver = new ServiceIsStorableResolver(),
        private IServiceBuilder $serviceBuilder = new ServiceBuilder(),
    ) {
    }

    public function create(mixed $value, IServiceDefinition $serviceDefinition): IService
    {
        $id = $serviceDefinition->getId();
        $isStorable = $this->isStorableResolver->isStorable($serviceDefinition);

        return $this->serviceBuilder
            ->withValue($value)
            ->withId($id)
            ->withIsStorable($isStorable)
            ->build()
        ;
    }
}
