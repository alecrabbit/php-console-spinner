<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Psr\Container\ContainerInterface;

interface IAutoInstantiator
{

    public static function registerContainer(ContainerInterface $container): void;

    public static function createInstance(string $class): object;
}
