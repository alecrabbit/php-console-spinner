<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Palette\Contract\IPalette;

interface IRevolverConfig
{
    public function getStylePalette(): IPalette;

    public function getCharPalette(): IPalette;
}
