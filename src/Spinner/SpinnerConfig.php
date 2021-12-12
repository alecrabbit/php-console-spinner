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
        private ILoop $loop,
    ) {
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
