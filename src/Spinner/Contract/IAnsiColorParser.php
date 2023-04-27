<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Contract;

use AlecRabbit\Spinner\Contract\Color\IColor;

interface IAnsiColorParser
{
    public function parseColor(IColor|null|string $color): string;
}
