<?php

declare(strict_types=1);
// 20.06.22
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\IClasses;
use AlecRabbit\Spinner\Config\Defaults\Contract\IDefaults;
use AlecRabbit\Spinner\Config\Defaults\Contract\ITerminal;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Loop\ReactLoopProbe;
use AlecRabbit\Spinner\Core\Loop\RevoltLoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Char\Snake;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Pattern\Style\Rainbow;
use AlecRabbit\Spinner\Core\Terminal\SymfonyTerminalProbe;
use AlecRabbit\Spinner\Factory\FrameFactory;

abstract class ADefaults extends ASettableDefaults implements IDefaults
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


    public function getClasses(): IClasses
    {
        return self::$classes;
    }

    /** @inheritdoc */
    public function getOutputStream()
    {
        return self::$outputStream;
    }

    public function getIntervalMilliseconds(): int
    {
        return self::$millisecondsInterval;
    }

    public function getShutdownDelay(): float|int
    {
        return self::$shutdownDelay;
    }

    public function isModeSynchronous(): bool
    {
        return self::$isModeSynchronous;
    }

    public function isHideCursor(): bool
    {
        return self::$hideCursor;
    }

    public function getFinalMessage(): string
    {
        return self::$messageOnFinalize;
    }


    public function getMessageOnExit(): string
    {
        return self::$messageOnExit;
    }

    public function getInterruptMessage(): string
    {
        return self::$messageOnInterrupt;
    }

    public function getMaxShutdownDelay(): float|int
    {
        return self::$shutdownMaxDelay;
    }

    public function setMaxShutdownDelay(float|int $maxShutdownDelay): static
    {
        self::$shutdownMaxDelay = $maxShutdownDelay;
        return $this;
    }

    public function getColorSupportLevels(): array
    {
        return self::$colorSupportLevels;
    }

    public function getPercentNumberFormat(): string
    {
        return self::$percentNumberFormat;
    }

    public function getSpinnerStylePattern(): IPattern
    {
        if (null === self::$mainStylePattern) {
            self::$mainStylePattern = new Rainbow();
        }
        return self::$mainStylePattern;
    }

    public function getSpinnerCharPattern(): IPattern
    {
        if (null === self::$mainCharPattern) {
            self::$mainCharPattern = new Snake();
        }
        return self::$mainCharPattern;
    }

    public function getMainLeadingSpacer(): IFrame
    {
        return
            self::$mainLeadingSpacer ?? self::$defaultLeadingSpacer;
    }

    public function getMainTrailingSpacer(): IFrame
    {
        return
            self::$mainTrailingSpacer ?? self::$defaultTrailingSpacer;
    }

    public function isCreateInitialized(): bool
    {
        return self::$createInitialized;
    }

    public function getDefaultLeadingSpacer(): IFrame
    {
        return self::$defaultLeadingSpacer;
    }

    public function getDefaultTrailingSpacer(): IFrame
    {
        return self::$defaultTrailingSpacer;
    }

    public function isAutoStartEnabled(): bool
    {
        return self::$autoStart;
    }

    public function areSignalHandlersEnabled(): bool
    {
        return self::$attachSignalHandlers;
    }

    public function getLoopProbeClasses(): iterable
    {
        return self::$loopProbes;
    }

    public function getTerminalProbeClasses(): iterable
    {
        return self::$terminalProbes;
    }

    public function getTerminal(): ITerminal
    {
        return self::$terminal;
    }
}
