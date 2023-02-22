<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Contract;

use AlecRabbit\Spinner\Core\Contract\ITimer;
use AlecRabbit\Spinner\Core\Output\Contract\IDriver;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

interface IConfig
{
    public function getDriver(): IDriver;

    public function getTimer(): ITimer;

    public function isAsynchronous(): bool;

    public function createInitialized(): bool;

    /**
     * @return IWidgetComposite[]
     */
    public function getWidgets(): iterable;

    public function getMainWidget(): IWidgetComposite;

    public function isAutoStart(): bool;

    public function shouldSetSignalHandlers(): bool;
}
