<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface INowTimer
{
    public function now(): float;
}
