<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Exception\DomainException;
use AlecRabbit\Spinner\Exception\InvalidArgumentException;
use AlecRabbit\Spinner\Exception\LogicException;

interface IAnsiStyleConverter
{
    /**
     * @throws InvalidArgumentException
     * @throws LogicException
     * @throws DomainException
     */
    public function ansiCode(int|string $color, StyleMode $colorMode): string;

    public function isEnabled(): bool;
}