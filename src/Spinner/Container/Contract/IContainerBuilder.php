<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Container\Contract;

interface IContainerBuilder
{
    public function build(): IContainer;
}
