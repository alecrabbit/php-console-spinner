<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Contract\IStyleSequenceFrame;
use AlecRabbit\Spinner\Core\Palette\Contract\IFinitePalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\StyleSequenceFrame;

final readonly class NoStylePalette implements IFinitePalette, IStylePalette
{
    public function __construct(
        private IPaletteOptions $options = new PaletteOptions(),
        private IStyleSequenceFrame $frame = new StyleSequenceFrame('%s', 0),
    ) {
    }

    public function getFrame(?float $dt = null): IStyleSequenceFrame
    {
        return $this->frame;
    }

    public function getOptions(): IPaletteOptions
    {
        return $this->options;
    }
}
