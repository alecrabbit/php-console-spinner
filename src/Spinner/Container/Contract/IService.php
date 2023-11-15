<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IService
{
    public function getValue(): mixed;

    public function getServiceDefinition(): IServiceDefinition;

    public function isStorable(): bool;
}
