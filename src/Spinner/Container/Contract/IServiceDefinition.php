<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceDefinition
{
    final public const SINGLETON = 0; // same instance every time, default
    final public const TRANSIENT = 1; // new instance every time

    public function getId(): string;

    /**
     * @return object|callable|class-string
     */
    public function getDefinition(): object|callable|string;

    public function getOptions(): int;
}
