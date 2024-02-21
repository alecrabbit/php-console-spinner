<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\INeoCharPattern;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;

interface ICharPatternFactory
{
    public function create(ICharPalette $palette): INeoCharPattern;
}
