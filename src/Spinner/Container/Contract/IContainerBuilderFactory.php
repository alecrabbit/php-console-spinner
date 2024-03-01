<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IContainerBuilderFactory
{
    public function create(): IContainerBuilder;
}
