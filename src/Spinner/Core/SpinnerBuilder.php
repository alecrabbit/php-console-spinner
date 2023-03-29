<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Contract\IContainer;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;

final class SpinnerBuilder implements ISpinnerBuilder
{
    protected ?IConfig $config = null;

    public function __construct(protected IContainer $container)
    {
    }

    public function build(): ISpinner
    {
        $this->config = $this->refineConfig($this->config);

        $driver =
            $this->container->get(IDriverBuilder::class)
                ->withDriverConfig($this->config->getDriverConfig())
                ->build();

        $rootWidget =
            $this->container->get(IWidgetBuilder::class)
                ->withWidgetConfig($this->config->getRootWidgetConfig())
                ->build();

        return new class($driver, $rootWidget) extends ASpinner {
        };
    }

    protected function refineConfig(?IConfig $config): IConfig
    {
        if (null === $config) {
            $config = $this->createConfig();
        }
        return $config;
    }

    protected function createConfig(): IConfig
    {
        return $this->container->get(IConfigBuilder::class)->build();
    }

    public function withConfig(?IConfig $config = null): self
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }
}