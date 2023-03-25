<?php

declare(strict_types=1);
// 23.03.23
namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Contract\Color\IColor;

interface IStyle
{

    public function getOptions(): IOptions|null;

    public function isEmpty(): bool;

    public function getFgColor(): IColor|string|null;

    public function getBgColor(): IColor|string|null;

    public function getFormat(): string;

    public function getWidth(): int;

    public function hasOptions(): bool;

    public function isOptionsOnly(): bool;
}
