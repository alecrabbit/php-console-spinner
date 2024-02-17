<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ISequenceFrame extends IFrame
{
    public function getSequence(): string;

    public function getWidth(): int;
}
