<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Contract\IContainer;

abstract class ABuilder
{
    public function __construct(protected IContainer $container)
    {
    }
}