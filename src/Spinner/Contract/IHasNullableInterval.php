<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasNullableInterval
{
    /**
     * @return null|IInterval
     */
    public function getInterval(): ?IInterval;
}
