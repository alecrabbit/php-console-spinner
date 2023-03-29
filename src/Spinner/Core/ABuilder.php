<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Factory\A\AHasContainer;

abstract class ABuilder extends AHasContainer
{
    protected function getDefaultsProvider(): IDefaultsProvider
    {
        return $this->container->get(IDefaultsProvider::class);
    }
}
