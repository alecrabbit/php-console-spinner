<?php

declare(strict_types=1);
// 10.03.23
namespace AlecRabbit\Spinner\Config\Defaults\A;

use AlecRabbit\Spinner\Config\Defaults\Contract\ISettableDefaults;
use AlecRabbit\Spinner\Core\Contract\IFrame;
use AlecRabbit\Spinner\Core\Loop\Contract\ILoopProbe;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Core\Terminal\Contract\ITerminalProbe;
use AlecRabbit\Spinner\Helper\Asserter;

abstract class ASettableDefaults extends ACoreDefaults implements ISettableDefaults
{
    /** @inheritdoc */
    public function setOutputStream($stream): static
    {
        Asserter::assertStream($stream);
        self::$outputStream = $stream;
        return $this;
    }

    public function setIntervalMilliseconds(int $defaultInterval): static
    {
        self::$millisecondsInterval = $defaultInterval;
        return $this;
    }

    public function setShutdownDelay(float|int $shutdownDelay): static
    {
        self::$shutdownDelay = $shutdownDelay;
        return $this;
    }

    public function setModeAsSynchronous(bool $isModeSynchronous): static
    {
        self::$isModeSynchronous = $isModeSynchronous;
        return $this;
    }

    public function setHideCursor(bool $hideCursor): static
    {
        self::$hideCursor = $hideCursor;
        return $this;
    }

    public function setFinalMessage(string $finalMessage): static
    {
        self::$messageOnFinalize = $finalMessage;
        return $this;
    }

    public function setMessageOnExit(string $messageOnExit): static
    {
        self::$messageOnExit = $messageOnExit;
        return $this;
    }

    public function setInterruptMessage(string $interruptMessage): static
    {
        self::$messageOnInterrupt = $interruptMessage;
        return $this;
    }

    /** @inheritdoc */
    public function setColorSupportLevels(array $colorSupportLevels): static
    {
        Asserter::assertColorSupportLevels($colorSupportLevels);
        self::$colorSupportLevels = $colorSupportLevels;
        return $this;
    }

    public function setPercentNumberFormat(string $percentNumberFormat): static
    {
        self::$percentNumberFormat = $percentNumberFormat;
        return $this;
    }


    public function setSpinnerStylePattern(IPattern $spinnerStylePattern): static
    {
        self::$mainStylePattern = $spinnerStylePattern;
        return $this;
    }

    public function setSpinnerCharPattern(IPattern $spinnerCharPattern): static
    {
        self::$mainCharPattern = $spinnerCharPattern;
        return $this;
    }

    public function setMainLeadingSpacer(IFrame $mainLeadingSpacer): static
    {
        self::$mainLeadingSpacer = $mainLeadingSpacer;
        return $this;
    }

    public function setMainTrailingSpacer(IFrame $mainTrailingSpacer): static
    {
        self::$mainTrailingSpacer = $mainTrailingSpacer;
        return $this;
    }

    public function setCreateInitialized(bool $createInitialized): static
    {
        self::$createInitialized = $createInitialized;
        return $this;
    }

    public function setAutoStart(bool $autoStart): static
    {
        self::$autoStart = $autoStart;
        return $this;
    }

    public function setAttachSignalHandlers(bool $attachSignalHandlers): static
    {
        self::$attachSignalHandlers = $attachSignalHandlers;
        return $this;
    }

    /** @inheritdoc */
    public function setTerminalProbeClasses(iterable $terminalProbes): static
    {
        foreach ($terminalProbes as $probe) {
            Asserter::isSubClass($probe, ITerminalProbe::class, __METHOD__);
        }
        self::$terminalProbes = $terminalProbes;
        return $this;
    }

    /** @inheritdoc */
    public function setLoopProbeClasses(iterable $loopProbes): static
    {
        foreach ($loopProbes as $probe) {
            Asserter::isSubClass($probe, ILoopProbe::class, __METHOD__);
        }
        self::$loopProbes = $loopProbes;
        return $this;
    }
}