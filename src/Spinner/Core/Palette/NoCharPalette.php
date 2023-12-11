<?php

declare(strict_types=1);

namespace AlecRabbit\Spinner\Core\Palette;

use AlecRabbit\Spinner\Core\CharFrame;
use AlecRabbit\Spinner\Core\Contract\ICharFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use Traversable;

final class NoCharPalette extends APalette implements ICharPalette
{
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        yield from [
            $this->createFrame(''),
        ];
    }

    protected function createFrame(string $element, ?int $width = null): ICharFrame
    {
        return new CharFrame($element, $width ?? 0);
    }
}
