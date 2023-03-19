<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\RunMode;

interface IDefaults extends ISettableDefaults
{
    public static function getInstance(): IDefaults;

    public function getProbeClasses(): \Traversable;

    public function getRootWidgetSettings(): IWidgetSettings;

    public function getWidgetSettings(): IWidgetSettings;

    public function getTerminalSettings(): ITerminalSettings;

    public function getDriverSettings(): IDriverSettings;

    public function getClasses(): IDefaultsClasses;

    public function getRunMode(): RunMode;

    /**
     * @return resource
     */
    public function getOutputStream();

    public function getIntervalMilliseconds(): int;

    public function isCreateInitialized(): bool;

    public function getPercentNumberFormat(): string;

    public function getShutdownDelay(): float|int;

    public function isModeSynchronous(): bool;

    public function getAutoStart(): AutoStart;

    public function areSignalHandlersEnabled(): bool;

    public function getStylePattern(): IPattern;

    public function getCharPattern(): IPattern;
}
