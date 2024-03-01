<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IContainerBuilder
{
    public function build(): IContainer;

    public function withFactory(IContainerFactory $factory): IContainerBuilder;

    public function withRegistry(IDefinitionRegistry $registry): IContainerBuilder;
}
