<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Frame\Contract;

interface ICharFrame
{
    public function getCharSequence(): string;

    public function getWidth(): int;
}
