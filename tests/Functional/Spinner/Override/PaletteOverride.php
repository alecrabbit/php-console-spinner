<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Spinner\Override;

use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteOptions;

class PaletteOverride extends APalette
{
    public function getEntries(?IPaletteOptions $options = null): \Traversable
    {
        throw new \RuntimeException('Not implemented.'); // Intentionally.
    }
}
