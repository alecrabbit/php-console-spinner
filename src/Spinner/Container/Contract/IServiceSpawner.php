<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceSpawner
{
    /**
     * @param class-string|callable $definition
     */
    public function spawn(string|callable $definition): object;
}
