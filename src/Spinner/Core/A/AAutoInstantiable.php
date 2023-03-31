<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Container\AutoInstantiator;
use Psr\Container\ContainerInterface;
use ReflectionClass;

abstract class AAutoInstantiable
{
    final public static function getInstance(): static
    {
        $reflection = new ReflectionClass(static::class);
        $constructorParameters = $reflection->getConstructor()?->getParameters();
        if ($constructorParameters) {
            $parameters = [];
            foreach ($constructorParameters as $parameter) {
                $parameters[$parameter->getName()] =
                    self::getContainer()->get($parameter->getType()?->getName());
            }
            return new static(...$parameters);
        }
    }

    protected static function getContainer(): ContainerInterface
    {
        return AutoInstantiator::getContainer();
    }
}
