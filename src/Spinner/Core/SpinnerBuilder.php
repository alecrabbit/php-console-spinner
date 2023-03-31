<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\A\ABuilder;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;

final class SpinnerBuilder extends ABuilder implements ISpinnerBuilder
{
    protected ?IConfig $config = null;

    public function build(): ISpinner
    {
        $this->config = $this->refineConfig($this->config);

        $driver =
            $this->getDriverBuilder()
                ->withDriverConfig($this->config->getDriverConfig())
                ->build()
        ;

        $rootWidget =
            $this->getWidgetBuilder()
                ->withWidgetConfig($this->config->getRootWidgetConfig())
                ->build()
        ;

        return
            new class($driver, $rootWidget) extends ASpinner {
            };
    }

    protected function refineConfig(?IConfig $config): IConfig
    {
        if (null === $config) {
            $config = $this->createDefaultConfig();
        }
        return $config;
    }

    protected function createDefaultConfig(): IConfig
    {
        return $this->getConfigBuilder()->build();
    }

    public function withConfig(IConfig $config): self
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }

}
