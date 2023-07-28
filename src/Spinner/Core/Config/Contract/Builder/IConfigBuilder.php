<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract\Builder;

use AlecRabbit\Spinner\Core\Config\Contract\IAuxConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IDriverConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Config\Contract\IWidgetConfig;
use AlecRabbit\Spinner\Exception\LogicException;

interface IConfigBuilder
{
    /**
     * @throws LogicException
     */
    public function build(): IConfig;

    public function withAuxConfig(IAuxConfig $auxConfig): IConfigBuilder;

    public function withLoopConfig(ILoopConfig $loopConfig): IConfigBuilder;

    public function withOutputConfig(IOutputConfig $outputConfig): IConfigBuilder;

    public function withDriverConfig(IDriverConfig $driverConfig): IConfigBuilder;

    public function withWidgetConfig(IWidgetConfig $widgetConfig): IConfigBuilder;

    public function withRootWidgetConfig(IWidgetConfig $rootWidgetConfig): IConfigBuilder;
}
