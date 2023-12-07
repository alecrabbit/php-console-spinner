<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Factory\Contract;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteTemplate;

interface IPaletteTemplateFactory
{
    public function create(IPalette $palette): IPaletteTemplate;
}
