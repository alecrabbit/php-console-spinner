<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Spinner;

final class SpinnerConfig implements ISpinnerConfig
{
    private const MAX_SHUTDOWN_DELAY = Defaults::MAX_SHUTDOWN_DELAY;
    private const INTERVAL = Defaults::SPINNER_FRAME_INTERVAL;

    /**
     * @throws LogicException|InvalidArgumentException
     */
    public function __construct(
        private readonly IDriver $driver,
        private readonly IWigglerContainer $wigglers,
        private readonly int|float $shutdownDelay,
        private readonly string $exitMessage,
        private readonly ?ILoop $loop = null,
        private readonly bool $synchronous = false,
        private readonly int|float $interval = self::INTERVAL,
        private readonly string $spinnerClass = Spinner::class,
    ) {
        $this->assertConfigIsCorrect();
    }

    /**
     * @throws LogicException|InvalidArgumentException
     */
    private function assertConfigIsCorrect(): void
    {
        $this->assertShutdownDelay();
        $this->assertRunMode();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertShutdownDelay(): void
    {
        if (0 > $this->shutdownDelay) {
            throw new  InvalidArgumentException('Shutdown delay can not be negative.');
        }
        if (0 === $this->shutdownDelay || 0.0 === $this->shutdownDelay) {
            throw new  InvalidArgumentException('Shutdown delay can not be equal to 0.');
        }
        if (self::MAX_SHUTDOWN_DELAY < $this->shutdownDelay) {
            throw new InvalidArgumentException(
                sprintf(
                    'Shutdown delay [%s] can not be greater than %s.',
                    $this->shutdownDelay,
                    self::MAX_SHUTDOWN_DELAY
                )
            );
        }
    }

    /**
     * @throws LogicException
     */
    private function assertRunMode(): void
    {
        if (null === $this->loop && $this->isAsynchronous()) {
            throw new LogicException(
                'You have chosen asynchronous mode configuration. It requires ILoop implementation to run.'
            );
        }
        if ($this->loop instanceof ILoop && $this->isSynchronous()) {
            throw new LogicException(
                'You have chosen synchronous mode configuration. Do not pass ILoop object.'
            );
        }
    }

    public function isAsynchronous(): bool
    {
        return !$this->isSynchronous();
    }

    public function isSynchronous(): bool
    {
        return $this->synchronous;
    }

    public function getExitMessage(): string
    {
        return $this->exitMessage;
    }

    /**
     * @throws LogicException
     */
    public function getLoop(): ILoop
    {
        if ($this->isAsynchronous()) {
            return $this->loop;
        }
        throw new LogicException('Configured for synchronous run mode. No loop object is available.');
    }

    public function getShutdownDelay(): int|float
    {
        return $this->shutdownDelay;
    }

    public function getSpinnerClass(): string
    {
        return $this->spinnerClass;
    }

    public function getInterval(): int|float
    {
        return $this->interval;
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }

    public function getWigglers(): IWigglerContainer
    {
        return $this->wigglers;
    }
}
