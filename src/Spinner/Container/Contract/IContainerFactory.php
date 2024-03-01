<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IContainerFactory
{
    public function create(IDefinitionRegistry $definitionRegistry): IContainer;

    public function isSupported(): bool;
}
