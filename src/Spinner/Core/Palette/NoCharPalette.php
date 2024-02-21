<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\ICharSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IFinitePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\CharSequenceFrame;

final readonly class NoCharPalette implements IFinitePalette, ICharPalette
{
    public function __construct(
        private IPaletteOptions $options = new PaletteOptions(),
        private ICharSequenceFrame $frame = new CharSequenceFrame('%s', 0),
    ) {
    }

    public function getFrame(?float $dt = null): ICharSequenceFrame
    {
        return $this->frame;
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
