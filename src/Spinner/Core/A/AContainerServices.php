<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\A;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Contract\IAnsiStyleConverter;
use AlecRabbit\Spinner\Contract\OptionStyleMode;
use AlecRabbit\Spinner\Core\Color\AnsiStyleConverter;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDefaultsProvider;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ILoopProbeFactory;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Factory\Contract\IRevolverFactory;
use AlecRabbit\Spinner\Core\Factory\LoopFactory;
use AlecRabbit\Spinner\Core\SpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetRevolverBuilder;
use AlecRabbit\Spinner\Core\WidgetBuilder;

abstract class AContainerServices
{
    public function __construct(
        protected IContainer $container,
    ) {
    }

    protected function getColorConverter(): IAnsiStyleConverter
    {
        return new AnsiStyleConverter(OptionStyleMode::ANSI8);
    }

    protected function getRevolverFactory(): IRevolverFactory
    {
        return $this->container->get(IRevolverFactory::class);
    }

    protected function getDefaultsProvider(): IDefaultsProvider
    {
        return $this->container->get(IDefaultsProvider::class);
    }

    protected function getConfigBuilder(): mixed
    {
        return $this->container->get(IConfigBuilder::class);
    }

    protected function getDriverBuilder(): IDriverBuilder
    {
        return $this->container->get(IDriverBuilder::class);
    }

    protected function getWidgetBuilder(): IWidgetBuilder
    {
        return $this->container->get(IWidgetBuilder::class);
    }

    protected function getSpinnerBuilder(): ISpinnerBuilder
    {
        return $this->container->get(ISpinnerBuilder::class);
//        return new SpinnerBuilder($this->container);
    }

    protected function getLoopProbeFactory(): ILoopProbeFactory
    {
        return $this->container->get(ILoopProbeFactory::class);
    }

    protected function getWidgetRevolverBuilder(): IWidgetRevolverBuilder
    {
        return $this->container->get(IWidgetRevolverBuilder::class);
    }
}
