<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Config\Config;

interface IConfig
{
    public function getAuxConfig(): IAuxConfig;

    public function getLoopConfig(): ILoopConfig;

    public function getOutputConfig(): IOutputConfig;

    public function getDriverConfig(): IDriverConfig;

    public function getWidgetConfig(): IWidgetConfig;

    public function getRootWidgetConfig(): IWidgetConfig;
}
