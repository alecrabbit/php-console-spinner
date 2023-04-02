<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IInstanceSpawner
{
    /**
     * @param class-string $class
     */
    public function spawn(string $class): object;
}
