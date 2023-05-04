<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract\Style;

use AlecRabbit\Spinner\Extras\Color\Contract\IColor;

interface IStyle
{
    public function getOptions(): IStyleOptions|null;

    public function isEmpty(): bool;

    public function getFgColor(): IColor|string|null;

    public function getBgColor(): IColor|string|null;

    public function getFormat(): string;

    public function getWidth(): int;

    public function hasOptions(): bool;

    public function isOptionsOnly(): bool;
}
