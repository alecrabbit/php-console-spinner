<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasInterval extends IHasNullableInterval
{
    public function getInterval(): IInterval;
}
