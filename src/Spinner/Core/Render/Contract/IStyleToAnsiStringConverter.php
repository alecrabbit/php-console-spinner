<?php

declare(strict_types=1);

// 23.03.23

namespace AlecRabbit\Spinner\Core\Render\Contract;

use AlecRabbit\Spinner\Contract\Color\Style\IStyle;

interface IStyleToAnsiStringConverter
{
    public function convert(IStyle $style): string;
}
