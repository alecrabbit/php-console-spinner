<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

final class NoStylePalette extends APalette implements IStylePalette
{
    public function __construct(IPaletteOptions $options = new PaletteOptions())
    {
        parent::__construct($options);
    }

    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        yield from [
            new StyleFrame('%s', 0),
        ];
    }
}
