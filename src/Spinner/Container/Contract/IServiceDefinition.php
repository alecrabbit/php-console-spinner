<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IServiceDefinition
{
    final public const DEFAULT = 0;                 // new instance every time
    final public const SINGLETON = 1;               // same instance every time
    final public const PUBLIC = 4;                  // public service

    public function getId(): string;

    /**
     * @return object|class-string
     */
    public function getDefinition(): object|string;

    public function isSingleton(): bool;

    public function isPublic(): bool;
}
