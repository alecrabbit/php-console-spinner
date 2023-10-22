<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ITolerance
{
    final public const DEFAULT_VALUE = 5; // milliseconds

    public function toMilliseconds(): int;
}
