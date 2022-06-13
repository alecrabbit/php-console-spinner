<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config;

use AlecRabbit\Spinner\Core\Config\Contract\IConfig;
use AlecRabbit\Spinner\Core\Contract\Base\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IWigglerContainer;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;

final class Config implements IConfig
{
    private const MAX_SHUTDOWN_DELAY = Defaults::MAX_SHUTDOWN_DELAY;

    /**
     * @throws LogicException|InvalidArgumentException
     */
    public function __construct(
        private readonly IDriver $driver,
        private readonly IWigglerContainer $wigglers,
        private readonly null|int|float $shutdownDelay,
        private readonly string $interruptMessage,
        private readonly string $finalMessage,
        private readonly bool $synchronous,
        private readonly ?ILoop $loop,
        private readonly int $colorSupportLevel,
    ) {
        $this->assert();
    }

    /**
     * @throws LogicException
     * @throws InvalidArgumentException
     */
    private function assert(): void
    {
        $this->assertShutdownDelay();
        $this->assertRunMode();
        $this->assertExitMessage();
        $this->assertColorSupportLevel();
        $this->assertInterruptMessage();
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertShutdownDelay(): void
    {
        if (null === $this->shutdownDelay) {
            return;
        }
        if (0 > $this->shutdownDelay) {
            throw new  InvalidArgumentException('Shutdown delay can not be negative.');
        }
//        if (0 === $this->shutdownDelay || 0.0 === $this->shutdownDelay) {
//            throw new  InvalidArgumentException('Shutdown delay can not be equal to 0.');
//        }
        if (self::MAX_SHUTDOWN_DELAY < $this->shutdownDelay) {
            throw new InvalidArgumentException(
                sprintf(
                    'Shutdown delay [%s] can not be greater than [%s].',
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

    private function assertExitMessage(): void
    {
        // TODO (2022-06-12 19:22) [Alec Rabbit]: Add exit message validation.
    }

    private function assertColorSupportLevel(): void
    {
        if (!in_array($this->colorSupportLevel, Defaults::COLOR_SUPPORT_LEVELS, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Color support level [%s] is not supported. Supported levels are: [%s].',
                    $this->colorSupportLevel,
                    implode(', ', Defaults::COLOR_SUPPORT_LEVELS)
                )
            );
        }
    }

    public function getInterruptMessage(): string
    {
        return $this->interruptMessage;
    }

    private static function synchronousModeException(string $reason): LogicException
    {
        return new LogicException(sprintf('Configured for synchronous run mode. No %s is available.', $reason));
    }

    public function getFinalMessage(): string
    {
        return $this->finalMessage;
    }

    /**
     * @throws LogicException
     */
    public function getLoop(): ILoop
    {
        if ($this->isAsynchronous()) {
            return $this->loop;
        }
        throw self::synchronousModeException('loop object');
    }

    /**
     * @throws LogicException
     */
    public function getShutdownDelay(): int|float
    {
        if ($this->isAsynchronous()) {
            return $this->shutdownDelay;
        }
        throw self::synchronousModeException('shutdown delay');
    }

    public function getDriver(): IDriver
    {
        return $this->driver;
    }

    public function getWigglers(): IWigglerContainer
    {
        return $this->wigglers;
    }

    public function getColorSupportLevel(): int
    {
        return $this->colorSupportLevel;
    }

    /**
     * @throws LogicException
     */
    private function assertInterruptMessage(): void
    {
        if (null === $this->interruptMessage && $this->isSynchronous()) {
            return;
        }
        if (null === $this->interruptMessage && $this->isAsynchronous()) {
            throw new LogicException(
                'You have chosen asynchronous mode configuration. It requires interrupt message.'
            );
        }
        // TODO (2022-06-13 13:50) [Alec Rabbit]: Add interrupt message validation.
    }
}
