<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\INeoCharPattern;
use AlecRabbit\Spinner\Core\Palette\Contract\INeoPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface ICharPatternFactory
{
    public function create(INeoPalette|IPalette $palette): INeoCharPattern;
}
