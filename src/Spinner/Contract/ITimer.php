<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface ITimer
{
    public function elapsed(): float;
}
