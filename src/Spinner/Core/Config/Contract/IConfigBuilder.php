<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IConfigBuilder
{
    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig;

    public function withDriverConfig(IDriverConfig $driverConfig): IConfigBuilder;

    public function withLoopConfig(ILoopConfig $loopConfig): IConfigBuilder;

    public function withSpinnerConfig(ISpinnerConfig $spinnerConfig): IConfigBuilder;

    public function withRootWidgetConfig(IWidgetConfig $widgetConfig): IConfigBuilder;

    public function withAuxConfig(IAuxConfig $auxConfig): IConfigBuilder;
}
