<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Contract;

interface INow
{
    public function now(): float;
}
