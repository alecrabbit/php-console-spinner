<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Override;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use RuntimeException;
use Traversable;

class StylePaletteOverride extends APalette implements IStylePalette
{
    protected function getEntries(?IPaletteMode $mode = null): Traversable
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
