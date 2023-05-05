<?php

declare(strict_types=1);


namespace AlecRabbit\Spinner\Extras\Contract;

use AlecRabbit\Spinner\Extras\Contract\Style\IStyle;

interface IStyleToAnsiStringConverter
{
    public function convert(IStyle $style): string;
}
