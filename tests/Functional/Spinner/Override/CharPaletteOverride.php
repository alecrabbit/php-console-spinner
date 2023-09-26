<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Override;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;

class CharPaletteOverride extends APalette implements ICharPalette
{
    public function getEntries(?IPaletteMode $entriesMode = null): \Traversable
    {
        throw new \RuntimeException('Not implemented.'); // Intentionally.
    }
}
