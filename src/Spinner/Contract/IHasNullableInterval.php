<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasNullableInterval
{
    public function getInterval(): ?IInterval;
}
