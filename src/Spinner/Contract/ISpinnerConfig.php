<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Frame;

interface ISpinnerConfig
{
    public function getOutput(): IOutput;

    public function getLoop(): ILoop;

    public function getColors(): Color;

    public function getFrames(): Frame;

    public function getShutdownDelay(): int|float;

    public function getExitMessage(): string;
}
