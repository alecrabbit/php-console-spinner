<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;

abstract class AContainerAware
{
    protected static ?IContainer $container = null;

    protected static function getContainer(): IContainer
    {
        if (null === static::$container) {
            static::$container = static::createContainer();
        }
        return static::$container;
    }

    private static function createContainer(): IContainer
    {
        return new Container();
    }
}