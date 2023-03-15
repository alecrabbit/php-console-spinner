<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\I\IFrame;
use AlecRabbit\Spinner\I\ILoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Helper\Asserter;

/** @internal */
abstract class ASettableDefaults extends ACoreDefaults
{
    /** @inheritdoc */
    public function setOutputStream($stream): static
    {
        Asserter::assertStream($stream);
        static::$outputStream = $stream;
        return $this;
    }

    public function setIntervalMilliseconds(int $defaultInterval): static
    {
        static::$millisecondsInterval = $defaultInterval;
        return $this;
    }

    public function setShutdownDelay(float|int $shutdownDelay): static
    {
        static::$shutdownDelay = $shutdownDelay;
        return $this;
    }

    public function setMaxShutdownDelay(float|int $maxShutdownDelay): static
    {
        static::$shutdownMaxDelay = $maxShutdownDelay;
        return $this;
    }

    public function setModeAsSynchronous(bool $isModeSynchronous): static
    {
        static::$isModeSynchronous = $isModeSynchronous;
        return $this;
    }

    public function setHideCursor(bool $hideCursor): static
    {
        static::$hideCursor = $hideCursor;
        return $this;
    }

    public function setFinalMessage(string $finalMessage): static
    {
        static::$messageOnFinalize = $finalMessage;
        return $this;
    }

    public function setMessageOnExit(string $messageOnExit): static
    {
        static::$messageOnExit = $messageOnExit;
        return $this;
    }

    public function setInterruptMessage(string $interruptMessage): static
    {
        static::$messageOnInterrupt = $interruptMessage;
        return $this;
    }

    /** @inheritdoc */
    public function setSupportedColorModes(iterable $supportedColorModes): static
    {
        Asserter::assertColorModes($supportedColorModes);
        static::$supportedColorModes = $supportedColorModes;
        return $this;
    }

    public function setPercentNumberFormat(string $percentNumberFormat): static
    {
        static::$percentNumberFormat = $percentNumberFormat;
        return $this;
    }


    public function setSpinnerStylePattern(IPattern $spinnerStylePattern): static
    {
        static::$mainStylePattern = $spinnerStylePattern;
        return $this;
    }

    public function setSpinnerCharPattern(IPattern $spinnerCharPattern): static
    {
        static::$mainCharPattern = $spinnerCharPattern;
        return $this;
    }

    public function setMainLeadingSpacer(IFrame $mainLeadingSpacer): static
    {
        static::$mainLeadingSpacer = $mainLeadingSpacer;
        return $this;
    }

    public function setMainTrailingSpacer(IFrame $mainTrailingSpacer): static
    {
        static::$mainTrailingSpacer = $mainTrailingSpacer;
        return $this;
    }

    public function setCreateInitialized(bool $createInitialized): static
    {
        static::$createInitialized = $createInitialized;
        return $this;
    }

    public function setAutoStart(bool $autoStart): static
    {
        static::$autoStart = $autoStart;
        return $this;
    }

    public function setAttachSignalHandlers(bool $attachSignalHandlers): static
    {
        static::$attachSignalHandlers = $attachSignalHandlers;
        return $this;
    }

    /** @inheritdoc */
    public function setTerminalProbeClasses(iterable $terminalProbes): static
    {
        foreach ($terminalProbes as $probe) {
            Asserter::isSubClass($probe, ITerminalProbe::class, __METHOD__);
        }
        static::$terminalProbes = $terminalProbes;
        return $this;
    }

    /** @inheritdoc */
    public function setLoopProbeClasses(iterable $loopProbes): static
    {
        foreach ($loopProbes as $probe) {
            Asserter::isSubClass($probe, ILoopProbe::class, __METHOD__);
        }
        static::$loopProbes = $loopProbes;
        return $this;
    }
}