<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Override;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\ICharPalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use RuntimeException;
use Traversable;

final class CharPaletteOverride extends APalette implements ICharPalette
{
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
