<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;

interface IStylePatternFactory
{
    public function create(IStylePalette $palette): INeoStylePattern;
}
