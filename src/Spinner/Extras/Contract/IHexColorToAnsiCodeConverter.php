<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Exception\InvalidArgumentException;

interface IHexColorToAnsiCodeConverter
{
    /**
     * @throws InvalidArgumentException
     */
    public function convert(string $color): string;
}
