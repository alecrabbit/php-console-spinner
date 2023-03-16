<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\ITimer;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\RunMode;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

abstract readonly class AConfig implements IConfig
{
    public function __construct(
        protected IDriver $driver,
        protected ITimer $timer,
        protected IWidgetComposite $rootWidget,
        protected bool $createInitialized,
        protected RunMode $runMode,
        protected bool $autoStart,
        protected bool $attachSignalHandlers,
        protected iterable $widgets = [],
    ) {
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }

    public function getTimer(): ITimer
    {
        return $this->timer;
    }

    public function isAsynchronous(): bool
    {
        return $this->runMode === RunMode::ASYNC;
    }

    public function createInitialized(): bool
    {
        return $this->createInitialized;
    }

    /**
     * @inheritdoc
     */
    public function getWidgets(): iterable
    {
        return $this->widgets;
    }

    public function getRootWidget(): IWidgetComposite
    {
        return $this->rootWidget;
    }

    public function isAutoStart(): bool
    {
        return $this->autoStart;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return $this->attachSignalHandlers;
    }

    public function getSignalHandlers(): ?iterable
    {
        // TODO: Implement getSignalHandlers() method.
        return null;
    }
}
