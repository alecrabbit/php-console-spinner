<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Factory\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;

abstract class AHasContainer
{

    public function __construct(protected IContainer $container)
    {
    }
}
