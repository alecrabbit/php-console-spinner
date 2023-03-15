<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Contract\IDriver;
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

    public function getRootWidget(): IWidgetComposite;

    public function isAutoStart(): bool;

    public function areSignalHandlersEnabled(): bool;

    public function getSignalHandlers(): ?iterable;
}
