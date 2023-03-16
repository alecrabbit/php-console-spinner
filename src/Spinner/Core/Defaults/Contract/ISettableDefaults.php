<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Defaults\Contract;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Pattern\Contract\IPattern;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface ISettableDefaults
{
    public static function registerProbeClass(string $class): void;

    /**
     * @param resource $stream
     * @throws InvalidArgumentException
     */
    public function setOutputStream($stream): static;

    /**
     * @throws InvalidArgumentException
     */
    public function setSupportedColorModes(array $supportedColorModes): static;

    public function setIntervalMilliseconds(int $defaultInterval): static;

    public function setCreateInitialized(bool $createInitialized): static;

    public function setPercentNumberFormat(string $percentNumberFormat): static;

    public function setShutdownDelay(float|int $shutdownDelay): static;

    public function setAutoStart(bool $autoStart): static;

    public function setAttachSignalHandlers(bool $attachSignalHandlers): static;

    /**
     * @throws InvalidArgumentException
     */
    public function overrideTerminalProbeClasses(iterable $terminalProbes): static;

    /**
     * @throws InvalidArgumentException
     */
    public function overrideLoopProbeClasses(iterable $loopProbes): static;

    public function setStylePattern(IPattern $spinnerStylePattern): static;

    public function setCharPattern(IPattern $spinnerCharPattern): static;
    }
