<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\ContainerFactory;

interface IContainerFactory
{

    public static function getContainer(): IContainer;

    public static function createContainer(): IContainer;
}
