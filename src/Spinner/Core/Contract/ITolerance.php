<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ITolerance
{
    final const DEFAULT_VALUE = 5; // milliseconds

    public function getValue(): int;
}
