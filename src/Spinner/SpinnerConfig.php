<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Frame;
use LogicException;
use RuntimeException;

final class SpinnerConfig implements ISpinnerConfig
{
    private const EXITING_CTRL_C_TO_FORCE = 'Exiting... (CTRL+C to force)';
    private const SHUTDOWN_DELAY = 0.5;

    public function __construct(
        private IOutput $output,
        private ?ILoop $loop = null,
        private bool $async = true,
        private string $exitMessage = self::EXITING_CTRL_C_TO_FORCE,
        private int|float $shutdownDelay = self::SHUTDOWN_DELAY,
    ) {
        $this->assertOperationMode();
    }

    public function isAsync(): bool
    {
        return $this->async;
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
        if ($this->isAsync()) {
            return $this->loop;
        }
        // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [92c57495-4d39-4092-a6b9-64e83c63862a]
        throw new RuntimeException('Spinner config for sync mode. No loop.');
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

    private function assertOperationMode(): void
    {
        if (null === $this->loop && $this->isAsync()) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [bb4c9b75-14d1-4ea5-addf-9b655d7a54b8]
            throw new LogicException(
                'You have chosen async configuration. It requires ILoop implementation to run.'
            );
        }
        if ($this->loop instanceof ILoop && !$this->isAsync()) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message 4a656564-4cdd-47b6-8bbf-bd86d033b2e7]
            throw new LogicException(
                'You have chosen sync configuration. Do not pass Loop object.'
            );
        }
    }
}
