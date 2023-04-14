<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\Option\OptionStyleMode;
use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IColorToAnsiCodeConverter
{
    /**
     * @throws InvalidArgumentException
     */
    public function ansiCode(string $color): string;
}
