<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\A;

use AlecRabbit\Spinner\Contract\IDriver;
use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Config\Contract\ILoopConfig;
use AlecRabbit\Spinner\Core\Widget\Contract\IWidgetComposite;

abstract readonly class AConfig implements IConfig
{
    public function __construct(
        protected IDriver $driver,
        protected IWidgetComposite $rootWidget,
        protected bool $createInitialized,
        protected iterable $widgets,
        protected ILoopConfig $loopConfig,
//        protected RunMode $runMode,
//        protected bool $autoStart,
//        protected bool $attachSignalHandlers,
    )
    {
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
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

    public function getLoopConfig(): ILoopConfig
    {
        return $this->loopConfig;
    }
}
