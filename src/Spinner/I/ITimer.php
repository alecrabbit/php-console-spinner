<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\I;

interface ITimer
{
    public function elapsed(): float;
}
