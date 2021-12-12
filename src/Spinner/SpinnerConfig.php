<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner;

use AlecRabbit\Spinner\Contract\ILoop;
use AlecRabbit\Spinner\Contract\IOutput;
use AlecRabbit\Spinner\Contract\ISpinnerConfig;

final class SpinnerConfig implements ISpinnerConfig
{
    public function __construct(
        private IOutput $output,
        private ?ILoop $loop = null,
        private $async = true,
    ) {
        if($this->async && null === $this->loop) {
            // FIXME (2021-12-12 21:6) [Alec Rabbit]: clarify message
            throw new \LogicException('You chose async configuration. It requires loop to run.');
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
