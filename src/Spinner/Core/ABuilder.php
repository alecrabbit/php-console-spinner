<?php
declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;

abstract class ABuilder
{
    public function __construct(protected IContainer $container)
    {
    }

    protected function getDefaultsProvider(): IDefaultsProvider
    {
        return $this->container->get(IDefaultsProvider::class);
    }
}