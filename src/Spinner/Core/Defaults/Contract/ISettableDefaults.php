<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\I\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISettableDefaults
{
    /**
     * @param resource $stream
     * @throws InvalidArgumentException
     */
    public function setOutputStream($stream): static;

    public function setHideCursor(bool $hideCursor): static;

    /**
     * @throws InvalidArgumentException
     */
    public function setSupportedColorModes(array $supportedColorModes): static;

    public function setIntervalMilliseconds(int $defaultInterval): static;

    public function setCreateInitialized(bool $createInitialized): static;

    public function setPercentNumberFormat(string $percentNumberFormat): static;

    public function setMainLeadingSpacer(IFrame $mainLeadingSpacer): static;

    public function setMainTrailingSpacer(IFrame $mainTrailingSpacer): static;

    public function setFinalMessage(string $finalMessage): static;

//    public function setDefaultLeadingSpacer(IFrame $defaultLeadingSpacer): static;
//
//    public function setDefaultTrailingSpacer(IFrame $defaultTrailingSpacer): static;

    public function setShutdownDelay(float|int $shutdownDelay): static;

//    public function setModeSynchronous(bool $modeSynchronous): static;

//    public function setClasses(IClasses $classes): static;

    public function setAutoStart(bool $autoStart): static;

    public function setAttachSignalHandlers(bool $attachSignalHandlers): static;

    /**
     * @throws InvalidArgumentException
     */
    public function setTerminalProbeClasses(iterable $terminalProbes): static;

    /**
     * @throws InvalidArgumentException
     */
    public function setLoopProbeClasses(iterable $loopProbes): static;

    public function setSpinnerStylePattern(IPattern $spinnerStylePattern): static;

    public function setSpinnerCharPattern(IPattern $spinnerCharPattern): static;

    public function setInterruptMessage(string $interruptMessage): static;
}
