<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Pattern\Factory\Contract;

use AlecRabbit\Spinner\Contract\Pattern\ITemplate;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface IPatternFactory
{
    public function create(IPalette $palette): ITemplate;
}
