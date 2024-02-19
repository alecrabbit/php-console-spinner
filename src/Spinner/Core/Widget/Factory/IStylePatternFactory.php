<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Widget\Factory;

use AlecRabbit\Spinner\Contract\Pattern\INeoStylePattern;
use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface IStylePatternFactory
{
    public function create(IPalette $palette): INeoStylePattern;
}
