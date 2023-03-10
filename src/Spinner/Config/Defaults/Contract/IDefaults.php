<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config\Defaults\Contract;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;

interface IDefaults extends ISettableDefaults
{
    public static function getInstance(): self;

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

    public function reset(): void;

    public function getDefaultLeadingSpacer(): IFrame;

    public function getDefaultTrailingSpacer(): IFrame;

    public function getShutdownDelay(): float|int;

    public function isModeSynchronous(): bool;

    public function getClasses(): IClasses;

    public function isAutoStartEnabled(): bool;

    public function areSignalHandlersEnabled(): bool;

    public function getLoopProbeClasses(): iterable;

    public function getTerminalProbeClasses(): iterable;

    public function getInterruptMessage(): string;

    public function getTerminal(): ITerminal;

    public function getSpinnerStylePattern(): IPattern;

    public function getSpinnerCharPattern(): IPattern;
}
