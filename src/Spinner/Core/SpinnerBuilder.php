<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Container\Mixin\AutoInstantiableTrait;
use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;

final class SpinnerBuilder implements ISpinnerBuilder
{
    use AutoInstantiableTrait;

    protected ?IConfig $config = null;

    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IWidgetBuilder $widgetBuilder,
        protected IConfigBuilder $configBuilder,
    ) {
    }

    public function build(): ISpinner
    {
        $this->config = $this->refineConfig($this->config);

        $driver =
            $this->driverBuilder
                ->withDriverConfig($this->config->getDriverConfig())
                ->build()
        ;

        $rootWidget =
            $this->widgetBuilder
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
        return $this->configBuilder->build();
    }

    public function withConfig(IConfig $config): self
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }

}
