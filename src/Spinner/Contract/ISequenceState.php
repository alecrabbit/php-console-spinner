<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISequenceState
{
    public function getPreviousWidth(): int;

    public function getSequence(): string;

    public function getWidth(): int;
}
