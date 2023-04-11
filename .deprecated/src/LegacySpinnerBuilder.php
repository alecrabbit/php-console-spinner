<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\A\ALegacySpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\ILegacyDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinner;
use AlecRabbit\Spinner\Core\Contract\ILegacySpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class LegacySpinnerBuilder implements ILegacySpinnerBuilder
{
    protected ?IConfig $config = null;

    public function __construct(
        protected ILegacyDriverBuilder $driverBuilder,
        protected IWidgetBuilder $widgetBuilder,
    ) {
    }

    public function build(): ILegacySpinner
    {
        $this->assertConfig();

        $driver =
            $this->driverBuilder
                ->withAuxConfig($this->config->getAuxConfig())
                ->withDriverConfig($this->config->getDriverConfig())
                ->build()
        ;

        $rootWidget =
            $this->widgetBuilder
                ->withWidgetConfig($this->config->getRootWidgetConfig())
                ->build()
        ;

        return
            new class($driver, $rootWidget) extends ALegacySpinner {
            };
    }

    protected function assertConfig(): void
    {
        if (null === $this->config) {
            throw new LogicException('Config is not set.');
        }
    }

    public function withConfig(IConfig $config): self
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }
}
