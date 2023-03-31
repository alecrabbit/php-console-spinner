<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\WidgetBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;

abstract class ABuilder extends AInstantiatesWithContainer
{
    protected function getDefaultsProvider(): IDefaultsProvider
    {
        return $this->container->get(IDefaultsProvider::class);
    }

    protected function getRevolverFactory(): IRevolverFactory
    {
        return $this->container->get(IRevolverFactory::class);
    }
}
