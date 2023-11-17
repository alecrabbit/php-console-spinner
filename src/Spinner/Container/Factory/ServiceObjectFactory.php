<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Factory;

use AlecRabbit\Spinner\Container\Contract;
use AlecRabbit\Spinner\Container\Contract\IIsStorableSolver;
use AlecRabbit\Spinner\Container\Contract\IService;
use AlecRabbit\Spinner\Container\Contract\IServiceDefinition;
use AlecRabbit\Spinner\Container\Contract\ServiceIsStorableSolver;
use AlecRabbit\Spinner\Container\Service;

final readonly class ServiceObjectFactory implements Contract\IServiceObjectFactory
{
    public function __construct(
        private IIsStorableSolver $isStorableSolver = new ServiceIsStorableSolver(),
    ) {
    }

    public function create(mixed $value, IServiceDefinition $serviceDefinition): IService
    {
        return new Service(
            value: $value,
            serviceDefinition: $serviceDefinition,
            storable: $this->isStorableSolver->isStorable($serviceDefinition),
        );
    }
}
