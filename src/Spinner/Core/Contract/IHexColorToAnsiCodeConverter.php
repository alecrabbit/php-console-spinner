<?php

declare(strict_types=1);

// 23.03.23

namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IHexColorToAnsiCodeConverter
{
    /**
     * @throws InvalidArgumentException
     */
    public function convert(string $color): string;
}
