<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Core\Contract;

use AlecRabbit\Spinner\Contract\OptionStyleMode;
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
    public function ansiCode(int|string $color, OptionStyleMode $styleMode): string;

    public function isDisabled(): bool;
}
