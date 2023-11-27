<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IContainerFactory
{
    public function __construct(IDefinitionRegistry $definitionRegistry);

    public function create(): IContainer;
}
