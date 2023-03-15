<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Core\Defaults\Contract\IDefaultsClasses;
use AlecRabbit\Spinner\Core\Pattern\Char\Ascii;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Style\Rainbow;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalSettings;
use AlecRabbit\Spinner\Helper\Deprecation;

abstract class ADefaults extends ASettableDefaults
{
    private static ?IDefaults $instance = null; // private, singleton

    private function __construct()
    {
        $this->reset();
    }

    final public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance =
                new class() extends ADefaults {
                };
        }
        return self::$instance;
    }

    public function getClasses(): IDefaultsClasses
    {
        return static::$classes;
    }

    /** @inheritdoc */
    public function getOutputStream()
    {
        return static::$outputStream;
    }

    public function getIntervalMilliseconds(): int
    {
        return static::$millisecondsInterval;
    }

    public function getShutdownDelay(): float|int
    {
        return static::$shutdownDelay;
    }

    public function isModeSynchronous(): bool
    {
        return static::$isModeSynchronous;
    }

    public function isHideCursor(): bool
    {
        return static::$hideCursor;
    }

    public function getFinalMessage(): string
    {
        return static::$messageOnFinalize;
    }


    public function getMessageOnExit(): string
    {
        return static::$messageOnExit;
    }

    public function getInterruptMessage(): string
    {
        return static::$messageOnInterrupt;
    }

    public function getMaxShutdownDelay(): float|int
    {
        return static::$shutdownMaxDelay;
    }

    public function getSupportedColorModes(): iterable
    {
        return static::$supportedColorModes;
    }

    public function getPercentNumberFormat(): string
    {
        return static::$percentNumberFormat;
    }

    public function getSpinnerStylePattern(): IPattern
    {
        if (null === static::$mainStylePattern) {
            static::$mainStylePattern = new Rainbow();
        }
        return static::$mainStylePattern;
    }

    public function getSpinnerCharPattern(): IPattern
    {
        if (null === static::$mainCharPattern) {
            static::$mainCharPattern = new Ascii();
        }
        return static::$mainCharPattern;
    }

    public function getMainLeadingSpacer(): IFrame
    {
        return
            static::$mainLeadingSpacer ?? static::$defaultLeadingSpacer;
    }

    public function getMainTrailingSpacer(): IFrame
    {
        return
            static::$mainTrailingSpacer ?? static::$defaultTrailingSpacer;
    }

    public function isCreateInitialized(): bool
    {
        return static::$createInitialized;
    }

    public function getDefaultLeadingSpacer(): IFrame
    {
        return static::$defaultLeadingSpacer;
    }

    public function getDefaultTrailingSpacer(): IFrame
    {
        return static::$defaultTrailingSpacer;
    }

    public function isAutoStartEnabled(): bool
    {
        return static::$autoStart;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return static::$attachSignalHandlers;
    }

    public function getLoopProbeClasses(): iterable
    {
        return static::$loopProbes;
    }

//    public function getTerminalProbeClasses(): iterable
//    {
//        return static::$terminalProbes;
//    }

    public function getTerminalSettings(): ITerminalSettings
    {
        return static::$terminalSettings;
    }
}
