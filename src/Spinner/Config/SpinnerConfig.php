<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Config;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Contract\ILoop;
use AlecRabbit\Spinner\Core\Contract\IOutput;
use AlecRabbit\Spinner\Core\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Frame;
use AlecRabbit\Spinner\Spinner;
use LogicException;
use RuntimeException;

final class SpinnerConfig implements ISpinnerConfig
{
    private const EXITING_CTRL_C_TO_FORCE = 'Exiting... (CTRL+C to force)';
    private const SHUTDOWN_DELAY = 0.5;

    public function __construct(
        private IOutput $output,
        private ?ILoop $loop = null,
        private bool $synchronous = false,
        private string $defaultClass = Spinner::class,
        private string $exitMessage = self::EXITING_CTRL_C_TO_FORCE,
        private int|float $shutdownDelay = self::SHUTDOWN_DELAY,
    ) {
        $this->assertRunMode();
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

    public function getOutput(): IOutput
    {
        return $this->output;
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
                'You have chosen sync configuration. Do not pass Loop object.'
            );
        }
    }

    public function getDefaultSpinnerClass(): string
    {
        return $this->defaultClass;
    }
}
