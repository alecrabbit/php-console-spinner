<?php

declare(strict_types=1);

// 09.03.23

namespace AlecRabbit\Spinner\Contract\Pattern;

use Traversable;

interface IPattern
{
    public function getEntries(): ?Traversable;

    public function getInterval(): ?int;

    public function isReversed(): bool;
}
