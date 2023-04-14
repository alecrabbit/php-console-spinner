<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IColorToAnsiCodeConverter
{
    /**
     * @throws InvalidArgumentException
     */
    public function ansiCode(string $color): string;
}
