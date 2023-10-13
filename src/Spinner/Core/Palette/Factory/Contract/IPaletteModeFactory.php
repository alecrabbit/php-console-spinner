<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Factory\Contract;

use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;

interface IPaletteModeFactory
{
    public function create(): IPaletteMode;
}
