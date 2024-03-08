<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\Mode\StylingMode;

interface IPaletteMode
{
    public function getStylingMode(): StylingMode;
}
