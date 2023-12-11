<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\Contract\IStyleFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use AlecRabbit\Spinner\Core\StyleFrame;
use Traversable;

final class NoStylePalette extends APalette implements IStylePalette
{
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        yield from [
            $this->createFrame('%s')
        ];
    }

    protected function createFrame(string $element, ?int $width = null): IStyleFrame
    {
        return new StyleFrame($element, $width ?? 0);
    }
}
