<?php

declare(strict_types=1);
// 29.03.23
namespace AlecRabbit\Spinner\Core;

use AlecRabbit\Spinner\Core\A\ASpinner;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverBuilder;
use AlecRabbit\Spinner\Core\Contract\IConfigBuilder;
use AlecRabbit\Spinner\Core\Contract\ISpinner;
use AlecRabbit\Spinner\Core\Contract\ISpinnerBuilder;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetBuilder;
use AlecRabbit\Spinner\Exception\LogicException;

final class SpinnerBuilder implements ISpinnerBuilder
{
    protected ?IConfig $config = null;

    public function __construct(
        protected IDriverBuilder $driverBuilder,
        protected IWidgetBuilder $widgetBuilder,
    ) {
    }

    public function build(): ISpinner
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
            new class($driver, $rootWidget) extends ASpinner {
            };
    }

    public function withConfig(IConfig $config): self
    {
        $clone = clone $this;
        $clone->config = $config;
        return $clone;
    }

    protected function assertConfig(): void
    {
        if (null === $this->config) {
            throw new LogicException('Config is not set.');
        }
    }
}
