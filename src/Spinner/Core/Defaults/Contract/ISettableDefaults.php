<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\AutoStart;
use AlecRabbit\Spinner\Contract\SignalHandlers;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISettableDefaults
{
    /**
     * @param class-string $class
     * @throws InvalidArgumentException
     */
    public static function registerProbeClass(string $class): void;

    /**
     * @param resource $stream
     * @throws InvalidArgumentException
     */
    public function setOutputStream($stream): static;

    public function setIntervalMilliseconds(int $defaultInterval): static;

    public function setCreateInitialized(bool $createInitialized): static;

    public function setPercentNumberFormat(string $percentNumberFormat): static;

    public function setShutdownDelay(float|int $shutdownDelay): static;

    public function overrideAutoStartOption(AutoStart $autoStart): static;

    public function overrideSignalHandlersOption(SignalHandlers $signalHandlers): static;

    /**
     * @throws InvalidArgumentException
     */
    public function overrideTerminalProbeClasses(\Traversable $terminalProbes): static;

    /**
     * @throws InvalidArgumentException
     */
    public function overrideLoopProbeClasses(\Traversable $loopProbes): static;

    public function setStylePattern(IPattern $spinnerStylePattern): static;

    public function setCharPattern(IPattern $spinnerCharPattern): static;
}
