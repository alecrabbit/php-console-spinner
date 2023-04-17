<?php

declare(strict_types=1);

// 10.04.23

namespace AlecRabbit\Spinner\Core\Contract;

interface ISpinnerState
{
    public function getPreviousWidth(): int;

    public function getSequence(): string;

    public function getWidth(): int;
}
