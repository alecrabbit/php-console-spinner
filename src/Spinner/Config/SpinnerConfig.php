<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Contract\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Spinner;
use InvalidArgumentException;
use LogicException;
use RuntimeException;

final class SpinnerConfig implements ISpinnerConfig
{
    private const MAX_SHUTDOWN_DELAY = Defaults::MAX_SHUTDOWN_DELAY;

    public function __construct(
        private IDriver $driver,
        private int|float $shutdownDelay,
        private string $exitMessage,
        private bool $synchronous = false,
        private ?ILoop $loop = null,
        private string $spinnerClass = Spinner::class,
    ) {
        $this->assertConfigIsCorrect();
    }

    private function assertConfigIsCorrect(): void
    {
        $this->assertRunMode();
        $this->assertShutdownDelay();
    }

    private function assertRunMode(): void
    {
        if (null === $this->loop && $this->isAsynchronous()) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [bb4c9b75-14d1-4ea5-addf-9b655d7a54b8]
            throw new LogicException(
                'You have chosen async configuration. It requires ILoop implementation to run.'
            );
        }
        if ($this->loop instanceof ILoop && $this->isSynchronous()) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message 4a656564-4cdd-47b6-8bbf-bd86d033b2e7]
            throw new LogicException(
                'You have chosen sync configuration. Do not pass ILoop object.'
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

    private function assertShutdownDelay(): void
    {
        if (0 > $this->shutdownDelay) {
            throw new  InvalidArgumentException('Shutdown delay can not be negative.');
        }
        if (0 === $this->shutdownDelay) {
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

    public function getExitMessage(): string
    {
        return $this->exitMessage;
    }

    public function getLoop(): ILoop
    {
        if ($this->isAsynchronous()) {
            return $this->loop;
        }
        throw new RuntimeException('Spinner configured for synchronous run mode. No loop.');
    }

    public function getColors(): Color
    {
        return new Color();
    }

    public function getFrames(): Frame
    {
        return new Frame();
    }

    public function getShutdownDelay(): int|float
    {
        return $this->shutdownDelay;
    }

    public function getSpinnerClass(): string
    {
        return $this->spinnerClass;
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }
}
