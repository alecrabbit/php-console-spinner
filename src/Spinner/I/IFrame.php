<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\I;

interface IFrame
{
    public function sequence(): string;

    public function width(): int;
}
