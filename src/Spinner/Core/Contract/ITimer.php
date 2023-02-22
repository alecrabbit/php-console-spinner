<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Contract;

interface ITimer
{
    public function elapsed(): float;
}
