<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\OptionRunMode;
use AlecRabbit\Spinner\Contract\Pattern\IPattern;
use Traversable;

interface IDefaults extends ISettableDefaults
{
    public static function getInstance(): IDefaults;

    public function getProbeClasses(): Traversable;

    public function getRootWidgetSettings(): IWidgetSettings;

    public function getWidgetSettings(): IWidgetSettings;

    public function getTerminalSettings(): ITerminalSettings;

    public function getDriverSettings(): IDriverSettings;

    public function getClasses(): IDefaultsClasses;

    public function getRunMode(): OptionRunMode;

    /**
     * @return resource
     */
    public function getOutputStream();

    public function getPercentNumberFormat(): string;

    public function getShutdownDelay(): float|int;

    public function isModeSynchronous(): bool;

    public function getStylePattern(): IPattern;

    public function getCharPattern(): IPattern;

    public function getLoopSettings(): ILoopSettings;

    public function getSpinnerSettings(): ISpinnerSettings;
}
