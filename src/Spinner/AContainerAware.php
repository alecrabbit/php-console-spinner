<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Container\Container;
use AlecRabbit\Spinner\Container\Contract\IContainer;

abstract class AContainerAware
{

    protected static function getContainer(): IContainer
    {
        return new Container();
    }
}