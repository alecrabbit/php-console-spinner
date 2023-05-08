<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract;

interface IHasInterval
{
    /**
     * @return IInterval
     */
    public function getInterval(): IInterval;
}
