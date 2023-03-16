<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Core\Defaults\A;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\RunMode;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Helper\Asserter;

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

    public function setRunMode(RunMode $mode): static
    {
        static::$runMode = $mode;
        return $this;
    }

    public function setModeAsSynchronous(bool $isModeSynchronous): static
    {
        static::$runMode = $isModeSynchronous ? RunMode::SYNCHRONOUS : RunMode::ASYNC;
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


    public function setStylePattern(IPattern $spinnerStylePattern): static
    {
        static::$stylePattern = $spinnerStylePattern;
        return $this;
    }

    public function setCharPattern(IPattern $spinnerCharPattern): static
    {
        static::$charPattern = $spinnerCharPattern;
        return $this;
    }

    public function setCreateInitialized(bool $createInitialized): static
    {
        static::$createInitialized = $createInitialized;
        return $this;
    }

    public function setAutoStart(bool $autoStart): static
    {
        static::$autoStartEnabled = $autoStart;
        return $this;
    }

    public function setAttachSignalHandlers(bool $attachSignalHandlers): static
    {
        static::$attachSignalHandlers = $attachSignalHandlers;
        return $this;
    }

    /** @inheritdoc */
    public function overrideTerminalProbeClasses(iterable $terminalProbes): static
    {
        foreach ($terminalProbes as $probe) {
            Asserter::isSubClass($probe, ITerminalProbe::class, __METHOD__);
        }
        static::$terminalProbes = $terminalProbes;
        return $this;
    }

    /** @inheritdoc */
    public function overrideLoopProbeClasses(iterable $loopProbes): static
    {
        foreach ($loopProbes as $probe) {
            Asserter::isSubClass($probe, ILoopProbe::class, __METHOD__);
        }
        static::$loopProbes = $loopProbes;
        return $this;
    }
}