<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

interface IConfig
{
    public function getAuxConfig(): IAuxConfig;

    public function getLoopConfig(): ILoopConfig;

    public function getOutputConfig(): IOutputConfig;

    public function getDriverConfig(): IDriverConfig;

    public function getWidgetConfig(): IWidgetConfig;

    public function getRootWidgetConfig(): IWidgetConfig;
}
