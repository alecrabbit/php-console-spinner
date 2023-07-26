<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Pattern;

interface IPattern
{
    public function getInterval(): ?int;

    public function isReversed(): bool;
}
