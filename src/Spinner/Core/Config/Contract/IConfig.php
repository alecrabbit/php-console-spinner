<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

interface IConfig
{
    public function getLoopConfig(): ILoopConfig;

    public function getDriver(): IDriver;

    public function createInitialized(): bool;

    /**
     * @return IWidgetComposite[]
     */
    public function getWidgets(): iterable;

    public function getRootWidget(): IWidgetComposite;

}
