<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IFrame
{
    public function getSequence(): string;

    public function getWidth(): int;
}
