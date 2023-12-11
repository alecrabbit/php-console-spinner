<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Spinner\Functional\Override;

use AlecRabbit\Spinner\Contract\IFrame;
use AlecRabbit\Spinner\Core\Palette\A\APalette;
use AlecRabbit\Spinner\Core\Palette\Contract\IPaletteMode;
use AlecRabbit\Spinner\Core\Palette\Contract\IStylePalette;
use RuntimeException;
use Traversable;

final class StylePaletteOverride extends APalette implements IStylePalette
{
    public function getEntries(?IPaletteMode $mode = null): Traversable
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }

    protected function createFrame(string $element, ?int $width = null): IFrame
    {
        throw new RuntimeException('INTENTIONALLY Not implemented.');
    }
}
