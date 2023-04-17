<?php

declare(strict_types=1);

// 15.04.23
namespace AlecRabbit\Spinner\Contract;

interface IAnsiColorParser
{
    public function parseColor(string $color): string;
}
