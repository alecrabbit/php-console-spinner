<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Config\Contract;

use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;

interface IWidgetRevolverConfig
{
    public function getStylePalette(): IStylePalette;

    public function getCharPalette(): ICharPalette;

    public function getRevolverConfig(): IRevolverConfig;
}
