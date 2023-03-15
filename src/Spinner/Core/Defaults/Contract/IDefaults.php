<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalSettings;

interface IDefaults extends ISettableDefaults
{
    public static function getInstance(): self;

    public static function registerProbe(string $class): void;

    /**
     * @return resource
     */
    public function getOutputStream();

    public function isHideCursor(): bool;

    public function getIntervalMilliseconds(): int;

    public function isCreateInitialized(): bool;

    public function getPercentNumberFormat(): string;

    public function getMainLeadingSpacer(): IFrame;

    public function getMainTrailingSpacer(): IFrame;

    public function getFinalMessage(): string;

    public function getDefaultLeadingSpacer(): IFrame;

    public function getDefaultTrailingSpacer(): IFrame;

    public function getShutdownDelay(): float|int;

    public function isModeSynchronous(): bool;

    public function getClasses(): IDefaultsClasses;

    public function isAutoStartEnabled(): bool;

    public function areSignalHandlersEnabled(): bool;

    public function getProbeClasses(): iterable;

//    public function getTerminalProbeClasses(): iterable;

    public function getInterruptMessage(): string;

    public function getTerminalSettings(): ITerminalSettings;

    public function getSpinnerStylePattern(): IPattern;

    public function getSpinnerCharPattern(): IPattern;
}
