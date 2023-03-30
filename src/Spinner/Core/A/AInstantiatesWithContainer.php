<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;

abstract class AInstantiatesWithContainer
{
    public function __construct(protected IContainer $container)
    {
    }
}
