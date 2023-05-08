<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\Contract;

use AlecRabbit\Spinner\Container\Contract\IContainer;

interface IContainerFactory
{
    public function getContainer(): IContainer;
}
