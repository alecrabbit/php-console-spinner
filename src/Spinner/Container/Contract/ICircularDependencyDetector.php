<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface ICircularDependencyDetector
{
    public function push(string $id): void;

    public function pop(): void;
}
