<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Builder;

use AlecRabbit\Spinner\Core\Config\Config;
use AlecRabbit\Spinner\Core\Config\Contract\Builder\IConfigBuilder;
use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Exception\LogicException;

/**
 * @psalm-suppress PossiblyNullArgument
 */
final class ConfigBuilder implements IConfigBuilder
{
    private ?IAuxConfig $auxConfig = null;
    private ?ILoopConfig $loopConfig = null;
    private ?IOutputConfig $outputConfig = null;
    private ?IDriverConfig $driverConfig = null;
    private ?IWidgetConfig $widgetConfig = null;
    private ?IWidgetConfig $rootWidgetConfig = null;


    /** @inheritDoc */
    public function build(): IConfig
    {
        $this->validate();

        return
            new Config();
    }

    /**
     * @throws LogicException
     */
    private function validate(): void
    {
        match (true) {
            $this->auxConfig === null => throw new LogicException('AuxConfig is not set.'),
            $this->loopConfig === null => throw new LogicException('LoopConfig is not set.'),
            $this->outputConfig === null => throw new LogicException('OutputConfig is not set.'),
            $this->driverConfig === null => throw new LogicException('DriverConfig is not set.'),
            $this->widgetConfig === null => throw new LogicException('WidgetConfig is not set.'),
            $this->rootWidgetConfig === null => throw new LogicException('RootWidgetConfig is not set.'),
            default => null,
        };
    }

    public function withAuxConfig(IAuxConfig $auxConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->auxConfig = $auxConfig;
        return $clone;
    }

    public function withLoopConfig(ILoopConfig $loopConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->loopConfig = $loopConfig;
        return $clone;
    }

    public function withOutputConfig(IOutputConfig $outputConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->outputConfig = $outputConfig;
        return $clone;
    }

    public function withDriverConfig(IDriverConfig $driverConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->driverConfig = $driverConfig;
        return $clone;
    }

    public function withWidgetConfig(IWidgetConfig $widgetConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->widgetConfig = $widgetConfig;
        return $clone;
    }

    public function withRootWidgetConfig(IWidgetConfig $rootWidgetConfig): IConfigBuilder
    {
        $clone = clone $this;
        $clone->rootWidgetConfig = $rootWidgetConfig;
        return $clone;
    }
}
