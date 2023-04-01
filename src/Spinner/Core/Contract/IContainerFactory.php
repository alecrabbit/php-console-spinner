<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Container\Contract\IContainer;

interface IContainerFactory
{
    public static function getContainer(): IContainer;
}
