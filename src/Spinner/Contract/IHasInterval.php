<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface IHasInterval extends IHasNullableInterval
{
    /**
     * @return IInterval
     */
    public function getInterval(): IInterval;
}
