<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

use Psr\Container\ContainerInterface;

interface IInstantiator
{
    /**
     * @param class-string $class
     */
    public function createInstance(string $class): object;
}
