<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Core\Color;
use AlecRabbit\Spinner\Core\Frame;

interface ISpinnerConfig
{
    public function isAsynchronous(): bool;

    public function isSynchronous(): bool;

    public function getOutput(): IOutput;

    public function getLoop(): ILoop;

    public function getColors(): Color;

    public function getFrames(): Frame;

    public function getShutdownDelay(): int|float;

    public function getExitMessage(): string;

    public function getDefaultSpinnerClass(): string;
}
