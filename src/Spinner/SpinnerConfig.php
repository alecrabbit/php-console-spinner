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
    public function __construct(
        private IOutput $output,
        private ?ILoop $loop = null,
        private bool $async = true,
    ) {
        if (null === $this->loop && $this->isAsync()) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [bb4c9b75-14d1-4ea5-addf-9b655d7a54b8]
            throw new LogicException('You have chosen async configuration. It requires loop to run.');
        }
    }

    public function isAsync(): bool
    {
        return $this->async;
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
}
