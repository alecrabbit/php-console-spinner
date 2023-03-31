<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use AlecRabbit\Spinner\Container\AutoInstantiator;
use AlecRabbit\Spinner\Container\Exception\ContainerAlreadyRegistered;
use Psr\Container\ContainerInterface;

interface IAutoInstantiator
{

    public static function registerContainer(ContainerInterface $container): void;
}
