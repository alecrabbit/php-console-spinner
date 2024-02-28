<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\ICharPattern;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;

interface ICharPatternFactory
{
    public function create(ICharPalette $palette): ICharPattern;
}
