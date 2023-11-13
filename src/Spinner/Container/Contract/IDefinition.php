<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IDefinition
{
    public function getId(): string;

    public function getDefinition(): object|callable|string;

    public function getOptions(): int;
}
