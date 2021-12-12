<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;
use LogicException;

final class SpinnerConfig implements ISpinnerConfig
{
    public function __construct(
        private IOutput $output,
        private ?ILoop $loop = null,
        private $async = true,
    ) {
        if ($this->async && null === $this->loop) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message [bb4c9b75-14d1-4ea5-addf-9b655d7a54b8]
            throw new LogicException('You have chosen async configuration. It requires loop to run.');
        }
    }

    public function getOutput(): IOutput
    {
        return $this->output;
    }

    public function getLoop(): ILoop
    {
        return $this->loop;
    }
}
