<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Override;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use RuntimeException;
use Traversable;

class PaletteOverride extends APalette
{
    protected function getEntries(?IPaletteMode $mode = null): Traversable
    {
        throw new RuntimeException('Not implemented.'); // Intentionally.
    }
}
