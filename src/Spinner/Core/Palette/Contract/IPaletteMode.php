<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Contract;

use AlecRabbit\Spinner\Contract\Mode\StylingMethodMode;

interface IPaletteMode
{
    public function getStylingMode(): StylingMethodMode;
}
