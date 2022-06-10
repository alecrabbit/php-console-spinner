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
use AlecRabbit\Spinner\Core\Rotor\Contract\IInterval;
use Throwable;

final class SpinnerConfig implements ISpinnerConfig
{
    private const MAX_SHUTDOWN_DELAY = Defaults::MAX_SHUTDOWN_DELAY;

    /**
     * @throws LogicException|InvalidArgumentException
     */
    public function __construct(
        private readonly IDriver $driver,
        private readonly IWigglerContainer $wigglers,
        private readonly null|int|float $shutdownDelay,
        private readonly ?string $exitMessage,
        private readonly bool $synchronous,
        private readonly ?ILoop $loop,
        private readonly IInterval $interval,
        private readonly int $colorSupportLevel,
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
        $this->assertColorSupportLevel();
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

    private function assertColorSupportLevel(): void
    {
        if(!in_array($this->colorSupportLevel, Defaults::COLOR_SUPPORT_LEVELS, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Color support level [%s] is not supported. Supported levels are: [%s].',
                    $this->colorSupportLevel,
                    implode(', ', Defaults::COLOR_SUPPORT_LEVELS)
                )
            );
        }
    }

    /**
     * @throws LogicException
     */
    public function getExitMessage(): string
    {
        if ($this->isAsynchronous()) {
            return $this->exitMessage;
        }
        throw self::synchronousModeException('exit message');
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

    public function getInterval(): IInterval
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

    public function getColorSupportLevel(): int
    {
        return $this->colorSupportLevel;
    }

    private static function synchronousModeException(string $reason): LogicException
    {
        return new LogicException(sprintf('Configured for synchronous run mode. No %s is available.', $reason));
    }
}
