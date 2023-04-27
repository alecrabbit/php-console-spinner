<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract;

interface IHasInterval
{
    public function getInterval(): IInterval;
}
