<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Contract\Defaults;
use AlecRabbit\Spinner\Core\Contract\IDriver;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IRenderer;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Core\Exception\LogicException;
use AlecRabbit\Spinner\Core\FrameHolder;
use AlecRabbit\Spinner\Core\Renderer;
use AlecRabbit\Spinner\Spinner;

final class SpinnerConfig implements ISpinnerConfig
{
    private const MAX_SHUTDOWN_DELAY = Defaults::MAX_SHUTDOWN_DELAY;
    private const INTERVAL = Defaults::SPINNER_FRAME_INTERVAL;
    private IRenderer $renderer;

    /**
     * @throws LogicException|InvalidArgumentException
     */
    public function __construct(
        private IDriver $driver,
        private int|float $shutdownDelay,
        private string $exitMessage,
        ?IRenderer $renderer = null,
        private int|float $interval = self::INTERVAL,
        private bool $synchronous = false,
        private ?ILoop $loop = null,
        private string $spinnerClass = Spinner::class,
    ) {
        $this->renderer = $this->refineRenderer($renderer);
        $this->assertConfigIsCorrect();
    }

    private function refineRenderer(?IRenderer $renderer): IRenderer
    {
        return
            new Renderer(
                new Color(),
                new FrameHolder(),
            );
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

    public function getColors(): Color
    {
        return new Color();
    }

    public function getFrames(): FrameHolder
    {
        return new FrameHolder();
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

    public function getInterval(): int|float
    {
        return $this->interval;
    }

    public function getRenderer(): IRenderer
    {
        return $this->renderer;
    }
}
