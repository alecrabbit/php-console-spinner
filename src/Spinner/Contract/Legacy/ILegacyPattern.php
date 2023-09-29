<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract\Legacy;

interface ILegacyPattern
{
    public function getInterval(): ?int;

    public function isReversed(): bool;
}
