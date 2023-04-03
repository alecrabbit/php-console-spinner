<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

interface IConfig
{
    public function getDriverConfig(): IDriverConfig;

    public function getLoopConfig(): ILoopConfig;

    public function getSpinnerConfig(): ISpinnerConfig;

    public function getRootWidgetConfig(): IWidgetConfig;

    public function getAuxConfig(): IAuxConfig;
}
