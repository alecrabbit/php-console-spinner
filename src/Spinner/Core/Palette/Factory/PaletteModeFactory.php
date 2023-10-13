<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette\Factory;

use AlecRabbit\Spinner\Core\Config\Contract\IOutputConfig;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Factory\Contract\IPaletteModeFactory;
use AlecRabbit\Spinner\Core\Palette\PaletteMode;

final class PaletteModeFactory implements IPaletteModeFactory
{
    public function __construct(
        protected IOutputConfig $outputConfig,
    ) {
    }

    public function create(): IPaletteMode
    {
        return
            new PaletteMode(
                stylingMode: $this->outputConfig->getStylingMethodMode(),
            );
    }
}
