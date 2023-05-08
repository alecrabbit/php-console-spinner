<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\ContainerFactory;

abstract class AContainerAware
{
    protected static function getContainer(): IContainer
    {
        return ContainerFactory::getContainer();
    }
}
