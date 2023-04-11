<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILegacySpinnerConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IConfigBuilder
{
    public function getDefaultsProvider(): IDefaultsProvider;

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    public function build(): IConfig;

    public function withDriverConfig(IDriverConfig $driverConfig): IConfigBuilder;

    public function withLoopConfig(ILoopConfig $loopConfig): IConfigBuilder;

    public function withSpinnerConfig(ILegacySpinnerConfig $spinnerConfig): IConfigBuilder;

    public function withRootWidgetConfig(IWidgetConfig $widgetConfig): IConfigBuilder;

    public function withAuxConfig(IAuxConfig $auxConfig): IConfigBuilder;
}
