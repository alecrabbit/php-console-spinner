<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;

abstract class ABuilder extends AInstantiatesWithContainer
{
    protected function getDefaultsProvider(): IDefaultsProvider
    {
        return $this->container->get(IDefaultsProvider::class);
    }
}
